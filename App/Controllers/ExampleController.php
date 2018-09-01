<?php
namespace App\Controllers;

use Core\Container\Container;
use Core\Core\Controller;
use App\Models\ExampleModel;

/**
 * Example controller class.
 * @property ExampleModel $model
 */
class ExampleController extends Controller
{
	/**
	 * ExampleController constructor.
	 *
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Example method
	 */
	public function indexAction()
	{
		// Get data from model.
		$data = $this->model->getData();

		// Render method will buffer view with passed data and write it to Response class for final output
		return $this->render('ExampleView', $data);
	}
}