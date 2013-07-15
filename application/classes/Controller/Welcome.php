<?php
/**
 * Defines Controller_Welcome for homepage and basic static pages
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 */

/**
 * Homepage and basic static pages
 */
class Controller_Welcome extends Controller
{

  /**
   * Show the homepage
   *
   * @return void
   */
  function action_index()
  {
	  // Grab 6 random ones for each category
	  $category_quotes = array();
	  foreach(Model_Quote::$category_names as $key => $name)
	  {
		  $category_quotes[$key] = Model_Quote::factory()->find_sample_for_category($key, 3);
	  }

	  // Generate and output the category view
	  $category_preview = View::factory('categories/list')
				 ->set('category_quotes', $category_quotes)
				 ->set('category_names', Model_Quote::$category_names);

	  $home = View::factory('home')
		  ->set('category_preview', $category_preview->render())
	  	  ->set('incoming_number', Kohana::$config->load('twilio')->get('incoming_number'));


   	  $template = View::factory('templates/default');
      $template->content = $home->render();

    $this->response->body($template->render());
  }

}
