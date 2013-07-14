<?php
/**
 * Models a single quote clipped from a recording
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Models a single quote clipped from a recording
 *
 * @property int             $id               The id
 * @property string          $description      The quote summary
 * @property string          $speakers         The person or people speaking
 * @property int             $start            Seconds into the main recording where the clip starts
 * @property int             $end              Seconds into the main recording where the clip ends
 * @property int             $provocative      Provocative score for this quote
 * @property int             $inspiring        Inspiring score for this quote
 * @property int             $meaningful       Meaningful score for this quote
 * @property int             $amusing          Amusing score for this quote
 * @property int             $intriguing       Intriguing score for this quote
 * @property string          $clip_url         URL for the rendered clip of this quote
 * @property string          $created_at       MYSQL timestamp of the quote creation time
 * @property Model_Recording $Recording        Recording this quote is cut from
 *
 */
class Model_Quote extends ORM
{

	const CATEGORY_PROVOCATIVE = 'provocative';
	const CATEGORY_INSPIRING = 'inspiring';
	const CATEGORY_MEANINGFUL = 'meaningful';
	const CATEGORY_AMUSING = 'amusing';
	const CATEGORY_INTRIGUING = 'intriguing';

	/**
	 * @var array relationship definitions
	 */
	protected $_belongs_to = array(
		'Recording' => array('foreign_key' => 'recording_id'),
	);

	/**
	 * @var array category names and field mappings
	 */
	public static $category_names = array(
		self::CATEGORY_PROVOCATIVE => 'provocative',
		self::CATEGORY_INSPIRING => 'inspiring',
		self::CATEGORY_MEANINGFUL => 'meaningful',
		self::CATEGORY_AMUSING => 'amusing',
		self::CATEGORY_INTRIGUING => 'intriguing'
	);

	/**
	 * @var array category numbers for phone menus
	 */
	public static $category_nums = array(
		1 => self::CATEGORY_PROVOCATIVE,
		2 => self::CATEGORY_INSPIRING,
		3 => self::CATEGORY_MEANINGFUL,
		4 => self::CATEGORY_AMUSING,
		5 => self::CATEGORY_INTRIGUING
	);

	/**
	 * Create an instance, optionally loading the record with specified ID from the database
	 *
	 * @param string $model The model to load
	 * @param int    $id    The ID to load
	 *
	 * @return Model_Quote
	 */
	public static function factory($model = 'Quote', $id = NULL)
	{
		return parent::factory($model, $id);
	}


	/**
	 * Return a random set of quotes for the category
	 *
	 * @param $category if null then anything
	 * @param $limit
	 *
	 * @return Database_Result|Model_Quote[]
	 */
	public function find_sample_for_category($category, $limit)
	{
		// If a category passed then limit the search
		if ($category) {
			$query = $this->where($category, '>', 0);
		} else {
			$query = $this;
		}
		$results = $query
			->with('Recording')
			->order_by(DB::expr('RAND()'))
			->limit($limit)
			->find_all();
		return $results;
	}

	/**
	 * Return all the quotes for the category
	 *
	 * @param $category
	 *
	 * @return Database_Result|Model_Quote[]
	 */
	public function find_all_for_category($category)
	{
		$results = $this->where($category, '>', 0)
				   ->with('Recording')
				   ->order_by(DB::expr('RAND()'))
				   ->find_all();
		return $results;
	}

}
