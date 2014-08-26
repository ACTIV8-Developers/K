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

	public function __construct()
	{
    	// Load model.
    	$this->model = $this->model('ExampleModel');
	}

	public function index(Request $request)
	{
    	// Get data from model.
    	$data['content'] = $this->model->getData();

    	// Render view and write it to response body.
    	$this->render('ExampleView', $data);
	}
}