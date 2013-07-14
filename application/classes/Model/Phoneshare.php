<?php
/**
 * Models a scheduled phone share
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Models a scheduled phone share
 *
 * @property int             $id            The id
 * @property string          $dest_number   The destination phone number
 * @property string          $sender_number The sender's phone number
 * @property string          $send_at       When to send
 * @property Model_Quote     $Quote         Quote to send
 * @property boolean         $ready         Ready to send (confirmed?)
 * @property boolean         $sent          Sent?
 * @property string          $greeting_url  Greeting message to send
 *
 */
class Model_Phoneshare extends ORM
{
	/**
	 * @var array relationship definitions
	 */
	protected $_belongs_to = array(
		'Quote' => array('foreign_key' => 'quote_id'),
	);

	/**
	 * Create an instance, optionally loading the record with specified ID from the database
	 *
	 * @param string $model The model to load
	 * @param int    $id    The ID to load
	 *
	 * @return Model_Phoneshare
	 */
	public static function factory($model = 'Phoneshare', $id = NULL)
	{
		return parent::factory($model, $id);
	}

}
