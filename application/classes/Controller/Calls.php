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

		// Read them the options
		$gather->addChild(
			'Say',
			'Welcome to authorquotes. Press 1 for provocative quotes, 2 for inspiring quotes, 3 for meaningful quotes, '
			.'4 for amusing quotes, 5 for intriguing quotes, or for a random quote press any other key'
		);

		// Add a fallback for a random quote
		$twiml->addChild('Redirect', '/calls/category_quote');
		$this->send_xml($twiml);
	}

	/**
	 * Handle user category selection - render a choice of authors
	 *
	 */
	public function action_category()
	{
		// placeholder
		$twiml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
		$twiml->addChild('Say', 'Yay');
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
		$this->response->body($xml->asXML());
		return;
	}

}
