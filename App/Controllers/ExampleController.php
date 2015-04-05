<?php
namespace Controllers;

use Core\Core\Controller;

/**
* Example controller class.
*/
class ExampleController extends Controller
{
	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		// Registered object in container
		$this->app['model'] = function() {
			return new \Models\ExampleModel();
		};
	}

	/**
	 * Example method I.
	 */
	public function indexAction()
	{
		// Get data from model.
		$data['content'] = $this->model->getData();

		// Render view with data and write it to response body.
		$this->render('ExampleView', $data);
	}

	/**
	 * Example method II.
	 */
	public function contactAction()
	{
		// Get request variables from Request object
		$post = $this->request->post->all();
		$get = $this->request->get->all();

		// Or use shortcut versions
		$post = $this->post();
		$get = $this->get();

		// Do something, call service, go to database, create form, send emails, etc...
    		
		// Get data
		$data['content'] = 'Contact me at milos@caenazzo.com';

		// Render method will buffer view and write it to Response class for final output
		$this->render('ExampleView', $data);
	}
}