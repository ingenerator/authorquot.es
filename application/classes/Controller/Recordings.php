<?php
/**
 * Controller for actions with recordings
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Controller for actions with recordings
 */
class Controller_Recordings extends Controller
{

	/**
	 * Render the player page for a single full recording. Requires an id route parameter
	 *
	 * @throws HTTP_Exception_403 if no ID
	 *
	 * @return void
	 */
	public function action_play()
	{
		// Find the recording data
		$id = $this->request->param('id', -1);
		$recording = Model_Recording::factory('Recording', $id);
		if ( ! $recording->loaded())
		{
			throw new HTTP_Exception_403("Recording ID '$id' could not be loaded");
		}

		$recording->Quotes->find_all();
		$recording->Authors->find_all();

		// Generate and output the view
		$content = View::factory('recording/play')
			->set('recording', $recording);
		$template = View::factory('templates/default')
			->set('title', $recording->title)
			->set('content', $content->render());

		$this->response->body($template->render());
	}

	public function action_quotes()
	{
		// Enforce POST to this method
		if ($this->request->method() != Request::POST) {
			throw new HTTP_Exception_400("This should be called with POST");
		}

		// Load the recording object
		$id = $this->request->param('id', -1);
		$recording = Model_Recording::factory('Recording', $id);
		if ( ! $recording->loaded())
		{
			throw new HTTP_Exception_403("Recording ID '$id' could not be loaded");
		}

		// Extract the POST data
		$filtered_post = Arr::extract(
			$this->request->post(),
			array(
				 'start',
				 'end',
				 'description',
				 'speakers',
				 'provocative',
				 'inspiring',
				 'meaningful',
				 'amusing',
				 'intriguing'
			)
		);
		$filtered_post['start'] = $this->_parse_time($filtered_post['start']);
		$filtered_post['end'] = $this->_parse_time($filtered_post['end']);

		// Create the quote object and save it initially
		$quote = new Model_Quote;
		$quote->Recording = $recording;
		$quote->values($filtered_post);
		$quote->save();

		// Create the clip

		// Render the response
		echo "OK";
	}

	/*
	 * Convert hours, mins, seconds to just seconds
	 *
	 * @param string $hms time in hours, mins seconds
	 *
	 * @return int
	 */
	protected function _parse_time($hms)
	{
		$parts = explode(':', $hms);
		return (3600 * $parts[0]) + (60 * $parts[1]) + $parts[2];
	}

}
