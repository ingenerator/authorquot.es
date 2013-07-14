<?php
/**
 * Import the data from JSON to database
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Import the data from JSON to database
 *
 */
class Task_Import extends Minion_Task
{
	/** @var array There are no options */
	protected $_options = array();

	/**
	 * Run the task
	 *
	 * @param array $params the command line params
	 *
	 * @throws Exception if the data isn't available
	 * @return void
	 */
	protected function _execute(array $params)
	{
		if ( ! file_exists(APPPATH.'/data/CHS_2013_Book_Festival_media_archive.json'))
		{
			throw new \Exception("You need the JSON data file");
		}

		$data = json_decode(file_get_contents(APPPATH . '/data/CHS_2013_Book_Festival_media_archive.json'), TRUE);

		$authors = array();

		foreach ($data as $recording_data)
		{
			if ($recording_data['type'] != 'Audio') {
				print "Skipping ".$recording_data['type'].PHP_EOL;
				continue;
			}
			$recording = Model_Recording::factory('Recording', $recording_data['id']);
			$recording->id = $recording_data['id'];
			$recording->url = $recording_data['url'];
			$recording->thumb_url = $recording_data['thumb_url'];
			$recording->title = $recording_data['title'];
			$recording->description_full = $recording_data['description_full'];
			$recording->save();

			foreach ($recording_data['related_authors'] as $author_data)
			{
				if ( ! isset($authors[$author_data['id']]))
				{
					$author = Model_Author::factory('Author', $author_data['id']);
					$author->id = $author_data['id'];
					$author->name = trim($author_data['forename'].' '.$author_data['surname']);
					$author->save();
					$authors[$author->id] = $author;
				} else {
					$author = $authors[$author_data['id']];
				}

				if ( ! $recording->has('Authors', $author->id))
				{
					$recording->add('Authors', $author);
				}
			}

		}
	}

}
