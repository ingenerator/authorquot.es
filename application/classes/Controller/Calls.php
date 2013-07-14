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
			$menu = 'Welcome to authorquotes. ';
			$session->set('said_hello', TRUE);
		}

		// Build the options from the model
		$menu .= 'Press ';
		foreach (Model_Quote::$category_nums as $num => $key) {
			$menu .= "$num for ".Model_Quote::$category_names[$key].", ";
		}
		$menu .= ' or for a random quote press any other key or wait.';

		$gather->addChild(
			'Say',
			$menu
		);

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

		$gather->addChild('Say', $menu);

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
			$twiml->addChild('Say', 'You did not select one of the offered quotes');
			$twiml->addChild('Redirect', '/calls/incoming');
			return $this->send_xml($twiml);
		}

		// Otherwise load and play the quote
		$quote = Model_Quote::factory('Quote', $offered[$digits]);
		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
		$twiml->addChild(
				 'Say',
				 'This is '.$quote->speakers.' on '.$quote->description
		);
		$play = $twiml->addChild('Play', $quote->clip_url);
		$play->addAttribute('loop', 1);
		$twiml->addChild('Redirect', '/calls/category');
		$this->send_xml($twiml);
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
