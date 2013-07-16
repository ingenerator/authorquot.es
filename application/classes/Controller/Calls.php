<?php
/**
 * Endpoint for incoming Twilio Call handling
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Endpoint for incoming Twilio Call handling
 */
class Controller_Calls extends Controller
{

	/**
	 * Handle an initial incoming call
	 *
	 */
	public function action_incoming()
	{
		/**
		 * Say a welcome greeting and find out what type of audio they want
		 */
		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');

		// Capture their category choice
		$gather = $twiml->addChild('Gather');
		$gather->addAttribute('action', '/calls/category');
		$gather->addAttribute('method', 'POST');
		$gather->addAttribute('timeout', 10);
		$gather->addAttribute('numDigits', 1);

		// Read them the options and say hello if they're new
		$session = $this->session();
		$menu = '';
		if ( ! $session->get('said_hello')) {
			$menu = 'Welcome to author quotes. ';
			$session->set('said_hello', TRUE);
		}

		// Build the options from the model
		$menu .= 'Press ';
		foreach (Model_Quote::$category_nums as $num => $key) {
			$menu .= "$num for ".Model_Quote::$category_names[$key].", ";
		}
		$menu .= ' or for a random quote press any other key or wait.';

		$this->add_twilio_say($gather, $menu);

		// Add a fallback for a random quote
		$twiml->addChild('Redirect', '/calls/category');
		$this->send_xml($twiml);
	}

	/**
	 * Handle user category selection - render a choice of authors
	 *
	 */
	public function action_category()
	{
		// Check if they requested a category or default to random
		$digits = $this->request->post('Digits');
		if (($digits < 1) || ($digits > 5)) {
			$category = NULL;
			$menu = 'Finding random quotes. ';
		} else {
			$category = Model_Quote::$category_nums[$digits];
			$menu = 'Finding '.Model_Quote::$category_names[$category].' quotes. ';
		}

		// Store their selected category in session
		$session = $this->session();
		$session->set('selected_category', $category);

		// Find them some quotes
		$quotes = Model_Quote::factory()->find_sample_for_category($category, 5);

		// Build the list for menu and session
		$offered_quotes = array();
		$digit = 1;
		foreach ($quotes as $quote) {
			$menu .= 'For '.$quote->speakers.' on '.$quote->description.' press '.$digit.'. ';
			$offered_quotes[$digit] = $quote->id;
			$digit++;
		}
		$menu .= ' Or to return to the category menu press any other key or hold.';
		$session->set('offered_quotes', $offered_quotes);

		// Build the twiML
		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');

		$gather = $twiml->addChild('Gather');
		$gather->addAttribute('action', '/calls/quote');
		$gather->addAttribute('method', 'POST');
		$gather->addAttribute('timeout', 10);
		$gather->addAttribute('numDigits', 1);

		$this->add_twilio_say($gather, $menu);

		// Fallback to go back to the category menu
		$twiml->addChild('Redirect', '/calls/incoming');
		$this->send_xml($twiml);
	}

	public function action_quote()
	{
		// Check if they requested a quote
		$digits = $this->request->post('Digits');

		$session = $this->session();
		$offered = $session->get('offered_quotes', array());

		if ( ! isset($offered[$digits])) {
			// Not an option
			$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
			$this->add_twilio_say(
				$twiml,
				'You did not select one of the offered quotes'
			);
			$twiml->addChild('Redirect', '/calls/incoming');
			return $this->send_xml($twiml);
		}

		// Otherwise load and play the quote
		$quote = Model_Quote::factory('Quote', $offered[$digits]);
		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
		$this->add_twilio_say(
			$twiml,
			'This is '.$quote->speakers.' at the Edinburgh International Book Festival'
		);
		$play = $twiml->addChild('Play', $quote->clip_url);
		$play->addAttribute('loop', 1);
		$twiml->addChild('Redirect', '/calls/category');
		$this->send_xml($twiml);
	}

	/**
	 * Schedule a phone share (this is POST and js only)
	 */
	public function action_scheduleshare()
	{
		// Enforce POST to this method
		if ($this->request->method() != Request::POST) {
			throw new HTTP_Exception_400("This should be called with POST");
		}

		// Enforce AJAX to this method
		if ( ! $this->request->is_ajax()) {
			throw new HTTP_Exception_400("You need to use AJAX for this");
		}

		// First create and store the model
		$share = new Model_Phoneshare;
		$share->values(
			Arr::extract($this->request->post(), array(
				'dest_number', 'sender_number', 'quote_id'
			))
		);

		// Just support sending now for now
		$share->send_at = date('Y-m-d H:i:s');
		$share->save();

		// Trigger the twilio call to confirm and record greeting
		$twilio = Twilio::create_client();
		$twilio->account->calls->create(
			Twilio::$our_number,
			$share->sender_number,
			URL::site('/calls/confirmshare?share_id='.$share->id, 'http', FALSE)
		);
	}

	/**
	 * Handles the call to the user to confirm they want to schedule a phone share of a quote
	 */
	public function action_confirmshare()
	{
		$share_id = $this->request->query('share_id');
		$share = Model_Phoneshare::factory('Phoneshare', $share_id);
		if ( ! $share->loaded()) {
			throw new HTTP_Exception_403("That's not a valid phoneshare_id");
		}

		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');

		// Add spaces between each digit
		$num = chunk_split($share->dest_number,1,' ');
		$this->add_twilio_say(
			$twiml,
			'This is author quotes. You asked us to share a quote of '.$share->Quote->speakers.' by phone to '.$num.'. '
			.' After the tone, please record a personal greeting for us to play before the quote, then press any key.'
		);

		$record = $twiml->addChild('Record');
		$record->addAttribute('action', '/calls/greetingrecorded?share_id='.$share_id);
		$record->addAttribute('maxLength', 60);
		$record->addAttribute('playBeep', TRUE);

		$this->add_twilio_say(
			$twiml,
			'You didn\'t say anything - your share has been cancelled'
		);

		$this->send_xml($twiml);
	}

	/**
	 * Confirm the share once the greeting has been recorded
	 */
	public function action_greetingrecorded()
	{
		$share_id = $this->request->query('share_id');
		$share = Model_Phoneshare::factory('Phoneshare', $share_id);
		if ( ! $share->loaded()) {
			throw new HTTP_Exception_403("That's not a valid phoneshare_id");
		}

		if ($this->request->post('Digits') === 'hangup') {
			// Just leave it
			return;
		}

		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
		$this->add_twilio_say(
			$twiml,
			'Great, we will share that quote for you.'
		);
		$share->greeting_url = $this->request->post('RecordingUrl');
		$share->ready = TRUE;
		$share->save();

		// Send the response now
		ignore_user_abort(TRUE);
		$this->send_xml($twiml);
		$this->response->send_headers();
		echo $this->response->body();
		while (ob_get_level()) {
			ob_get_flush();
		}
		flush();


		// Now send the call
		$twilio = Twilio::create_client();
		$twilio->account->calls->create(
			Twilio::$our_number,
			$share->dest_number,
			URL::site('/calls/playshare?share_id='.$share->id, 'http', FALSE)
		);
		exit;
	}

	/**
	 * Handles the call to the user to confirm they want to schedule a phone share of a quote
	 */
	public function action_playshare()
	{
		$share_id = $this->request->query('share_id');
		$share = Model_Phoneshare::factory('Phoneshare', $share_id);
		if ( ! $share->loaded()) {
			throw new HTTP_Exception_403("That's not a valid phoneshare_id");
		}

		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');

		// Play the greeting
		$greet = $twiml->addChild('Play', $share->greeting_url);
		$greet->addAttribute('loop', 1);

		$quote = $share->Quote;
		$play = $twiml->addChild('Play', $quote->clip_url);
		$play->addAttribute('loop', 1);

		$this->add_twilio_say(
			$twiml,
			'That was '.$quote->speakers.' at the Edinburgh International Book Festival. This call was powered by author quotes and lots of coffee'
		);

		$this->send_xml($twiml);
	}

	protected function add_twilio_say(SimpleXMLElement $parent, $text)
	{
		$say = $parent->addChild('Say', $text);
		$say->addAttribute('voice', 'alice');
		$say->addAttribute('language', 'en-gb');
		return $say;
	}


	/**
	 * Send an XML response to the caller
	 *
	 * @param SimpleXMLElement $xml the xml to send
	 *
	 * @return void
	 */
	protected function send_xml(SimpleXMLElement $xml)
	{
		$this->response->headers('Content-Type', 'text/xml');
		$this->response->headers('Expires', 'Tue, 06 Dec 2011 20:24:15 GMT');
		$this->response->body($xml->asXML());
		return;
	}

	/**
	 * Get the session
	 *
	 * @return Session
	 * @throws Exception
	 */
	protected function session()
	{
		$sid = $this->request->post('CallSid');
		if ( ! $sid) {
			throw new Exception("No incoming session ID!");
		}
		$session = Session::instance(NULL, $sid);
		return $session;
	}

}
