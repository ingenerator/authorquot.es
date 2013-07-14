<?php
/**
 * Controller for actions with quote categories
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Controller for actions with quote categories - actions with individual quotes are under Controller_Recordings
 */
class Controller_Categories extends Controller
{

	/**
	 * Render a list of all the categories
	 *
	 * @return void
	 */
	public function action_list()
	{
		// Grab 6 random ones for each category
		$category_quotes = array();
		foreach(Model_Quote::$category_names as $key => $name)
		{
			$category_quotes[$key] = Model_Quote::factory()->find_sample_for_category($key, 6);
		}

		// Generate and output the view
		$content = View::factory('categories/list')
				   ->set('category_quotes', $category_quotes)
				   ->set('category_names', Model_Quote::$category_names);

		$template = View::factory('templates/default')
					->set('title', 'Quote Categories')
					->set('content', $content->render());

		$this->response->body($template->render());
	}

	/**
	 * Show all quotes in a category
	 */
	public function action_show()
	{
		// Get the category
		$category = $this->request->param('category');
		$quotes = Model_Quote::factory()->find_all_for_category($category);

		// Generate and output the view
		$content = View::factory('categories/list_quotes')
				   ->set('quotes', $quotes)
				   ->set('category_name', Model_Quote::$category_names[$category]);

		$template = View::factory('templates/default')
					->set('title', Model_Quote::$category_names[$category].' categories')
					->set('content', $content->render());

		$this->response->body($template->render());
	}
}
