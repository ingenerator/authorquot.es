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
	 * Render a list of all the recordings
	 *
	 * @return void
	 */
	public function action_list()
	{
		$recordings = Model_Recording::factory()
			->with('Quotes')
			->find_all();

		// Generate and output the view
		$content = View::factory('recording/list')
				   ->set('recordings', $recordings);
		$template = View::factory('templates/default')
					->set('title', 'All recordings')
					->set('content', $content->render());

		$this->response->body($template->render());
	}

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
			->set('recording', $recording)
			->set('auto_play', $this->request->query('play'));
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

		// Enforce AJAX to this method
		if ( ! $this->request->is_ajax()) {
			throw new HTTP_Exception_400("You need to use AJAZ for this");
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

		// This next bit is nasty - don't look!

		// Grab the S3 file if required
		$orig_recording = '/tmp/'.basename($recording->url);
		if ( ! file_exists($orig_recording)) {
			$this->exec_shell('wget -O '.escapeshellarg($orig_recording).' '.escapeshellarg($recording->url));
		}

		// Build the quote file name
		$quote_path = '/quotes/'.$recording->id;
		$quote_file = $quote_path.'/'.$quote->id.'.mp3';
		if ( ! file_exists(DOCROOT.$quote_path))
		{
			mkdir(DOCROOT.$quote_path, 0755, TRUE);
		}

		// Build the clipping params - by default add 0.8 seconds either side of user times to allow for the fade
		$trim_start = ($quote->start > 0) ? $quote->start - 0.8 : 0;
		$trim_end = $quote->end + 0.8;

		$cmd = 'sox '
			.escapeshellarg($orig_recording).' '
			.escapeshellarg(DOCROOT.$quote_file).' '
			.'trim '.round($trim_start, 1).' ='.round($trim_end, 1).' '
			.'fade 1 0';
		$this->exec_shell($cmd);
		$quote->clip_url = $quote_file;
		$quote->save();

		// Render a response
		$response = array(
			'success'    => TRUE,
			'clip_url'   => Url::site($quote->clip_url, 'http', FALSE),
			'share_url'  => '/foo',
			'quote_view' => View::factory('recording/quote_table')
							->set('quotes', array($quote))
							->set('recording', $recording)
							->set('row_only', TRUE)
							->render()
		);
		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($response));
	}

	/**
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

	/**
	 * Run command in shell, throw exception on failure
	 *
	 * @param string $cmd the command to execute
	 *
	 * @throws Exception if it fails
	 */
	protected function exec_shell($cmd)
	{
		exec($cmd, $output, $return);

		if ($return !== 0)
		{
			throw new Exception("Shell task `$cmd` failed with code $return".PHP_EOL.'|\t'.implode(PHP_EOL.'|\t', $output));
		}
	}

}
