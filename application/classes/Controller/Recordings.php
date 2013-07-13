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
		$id = $this->request->param('id');
		if (!$id)
		{
			throw new HTTP_Exception_403("id parameter is required");
		}
		$recording = $this->get_recording($id);

		// Generate and output the view
		$content = View::factory('recording/play')
			->set('recording', $recording);
		$template = View::factory('templates/default')
			->set('title', $recording['title'])
			->set('content', $content->render());

		$this->response->body($template->render());
	}

	/**
	 * @param $id
	 *
	 * @return array the recording data
	 * @throws HTTP_Exception_403
	 */
	protected function get_recording($id)
	{
		$data = json_decode(file_get_contents(APPPATH . '/data/CHS_2013_Book_Festival_media_archive.json'), TRUE);
		// Have to iterate as the ids are not available as keys
		foreach ($data as $recording)
		{
			if ($recording['id'] === $id)
			{
				if ($recording['type'] != 'Audio')
				{
					throw new HTTP_Exception_403("recording id $id is not an audio");
				}
				return $recording;
			}
		}

		throw new HTTP_Exception_403("recording $id is not found");
	}

}
