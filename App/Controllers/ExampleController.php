<?php
namespace Controllers;

use \Core\Http\Request as Request;

/**
* Example controller class.
*/
class ExampleController extends \Controller
{
	/**
	* @var object \Models\ExampleModel
	*/
	private $model;

	/**
	* Class constructor.
	*/
	public function __construct()
	{
    	// Load model.
    	$this->model = $this->model('ExampleModel');
	}

	/**
	* Example method.
	*/
	public function index(Request $request)
	{
    	// Get data from model.
    	$data['content'] = $this->model->getData();

    	// Render view and write it to response body.
    	$this->render('ExampleView', $data);
	}
}