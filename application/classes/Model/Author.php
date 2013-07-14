<?php
/**
 * Models a single author
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Models a single author
 *
 * @property int             $id         The id
 * @property string          $name       The author's name
 * @property Model_Recording $Recordings Recordings featuring this author
 *
 */
class Model_Author extends ORM
{
	/**
	 * @var array relationship definitions
	 */
	protected $_has_many = array(
		'Recordings' => array('through' => 'authors_recordings'),
	);

	/**
	 * Create an instance, optionally loading the record with specified ID from the database
	 *
	 * @param string $model The model to load
	 * @param int    $id    The ID to load
	 *
	 * @return Model_Author
	 */
	public static function factory($model = 'Author', $id = NULL)
	{
		return parent::factory($model, $id);
	}


}
