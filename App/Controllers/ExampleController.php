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
	* Example method.
	*
	* @param object \Core\Http\Request
	*/
	public function index(Request $request)
	{
    	// Get data from model.
    	$data['content'] = $this->model->getData();

    	// Render view with data and write it to response body.
    	$this->render('ExampleView', $data);
	}
}