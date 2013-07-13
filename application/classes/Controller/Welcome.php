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
    $template = View::factory('templates/default');
    $template->content = View::factory('home');

    $this->response->body($template->render());
  }

}
