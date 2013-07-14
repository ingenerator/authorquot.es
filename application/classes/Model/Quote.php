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

	/**
	 * @var array relationship definitions
	 */
	protected $_belongs_to = array(
		'Recording' => array('foreign_key' => 'recording_id'),
	);

}
