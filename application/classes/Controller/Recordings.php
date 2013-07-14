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

}
