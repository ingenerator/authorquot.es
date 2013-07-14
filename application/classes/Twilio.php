<?php
/**
 * Very thin wrapper to load the Twilio library with Kohana config
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */
class Twilio {

	public static $our_number = NULL;

	/**
	 * Create the twilio service client
	 *
	 * @return Services_Twilio
	 */
	public static function create_client()
	{
		require_once(DOCROOT.'/../vendor/twilio/sdk/Services/Twilio.php');
		$config = Kohana::$config->load('twilio');
		self::$our_number = $config['incoming_number'];
		$client = new Services_Twilio($config['sid'], $config['token']);
		return $client;
	}

}
