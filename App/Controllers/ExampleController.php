<?php
namespace App\Controllers;

use Core\Core\Controller;
use App\Models\ExampleModel;

/**
 * Example controller class.
 * @property ExampleModel $model
 */
class ExampleController extends Controller
{
	/**
	 * Example method I.
	 */
	public function indexAction()
	{
		// Get data from model.
		$data['content'] = $this->model->getData();

		// Render method will buffer view with passed data and write it to Response class for final output
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

		// Do something, call service, go to database, create form, send emails, etc...
    	###############################################################################
    		
		// Store data for display
		$data['content'] = 'Contact me at milos@caenazzo.com';

		// Render method will buffer view with passed data and write it to Response class for final output
		$this->render('ExampleView', $data);
	}
}