<?php
namespace App\Controllers;

use Core\Core\Controller;

/**
 * Example controller class.
 */
class ExampleController extends Controller
{
	/**
	 * Example method I.
	 */
	public function indexAction()
	{
		// Register model object in container
		$this->app['model'] = function($c) {
			return (new \App\Models\ExampleModel())->setApp($c);
		};

		// Get data from model.
		$data['content'] = $this->model->getData();

		// Render method will buffer view and write it to Response class for final output
		$this->render('ExampleView', $data);	
	}

	/**
	 * Example method II.
	 */
	public function contactAction()
	{
		// Get request variables from Request object
		$get = $this->request->get->all();
		$post = $this->request->post->all();
		
		// Or use shortcut versions
		$get = $this->get();
		$post = $this->post();

		// Do something, call service, go to database, create form, send emails, etc...
    	###############################################################################
    		
		// Get data
		$data['content'] = 'Contact me at milos@caenazzo.com';

		// Render method will buffer view and write it to Response class for final output
		$this->render('ExampleView', $data);
	}
}