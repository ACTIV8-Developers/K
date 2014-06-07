<?php
namespace Controllers;

/**
* Example controller class.
*/
class ExampleController extends \Controller
{
	public function __construct()
	{
    	// Load model
    	$this->model = $this->model('ExampleModel');
	}

	public function index()
	{
    	// Get data from model
    	$data['content'] = $this->model->getData();
    	// Load data into view and display it
    	$this->response()->render('ExampleView', $data);
	}
}