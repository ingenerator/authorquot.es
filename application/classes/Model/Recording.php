<?php
/**
 * Models a single recording entity
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Models a single recording
 *
 * @property int          $id               The id
 * @property string       $url              The media URL
 * @property string       $thumb_url        The thumbnail URL
 * @property string       $title            The title
 * @property string       $description_full The description text
 * @property Model_Quote  $Quotes           Model to find quotes snipped from this recording
 * @property Model_Author $Authors          Model to find authors related to these authors
 *
 */
class Model_Recording extends ORM
{
	/**
	 * @var array Define the many relations
	 */
	protected $_has_many = array(
		'Quotes' => array(),
		'Authors' => array('through' => 'authors_recordings')
	);

	/**
	 * Create an instance, optionally loading the record with specified ID from the database
	 *
	 * @param string $model The model to load
	 * @param int    $id    The ID to load
	 *
	 * @return Model_Recording
	 */
	public static function factory($model = 'Recording', $id = NULL)
	{
		return parent::factory($model, $id);
	}

}
