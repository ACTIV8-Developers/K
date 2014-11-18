<?php
namespace Controllers;

use \Core\Core\Controller;

/**
* Example controller class.
*/
class ExampleController extends Controller
{
	/**
	* @var object \Models\ExampleModel
	*/
	protected $model;

	/**
	* Class constructor.
	*/
	public function __construct()
	{
    	// Load model.
    	$this->model = $this->model('ExampleModel');
	}

	/**
	* Example method I.
	*
	* @param object \Core\Http\Request
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
        // Get post request variables.
        $post = $this->request->post();
        // Do something, call service, go to database, create form, send emails, etc...

    	// Get data from model.
    	$data['content'] = 'Contact me at miloskajnaco@gmail.com';

        // Render method will buffer view and write it to Response class for final output.
    	$this->render('ExampleView', $data);
	}
}