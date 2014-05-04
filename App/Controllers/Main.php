<?php
/**
* Main controller class.
*/
class Main extends Controller
{
	public function index()
	{
		// Load data into view and display it
		$this->response()->render('Template', []);
	}
}