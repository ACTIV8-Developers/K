<?php
namespace App\Controllers;

use Core\Core\Controller;
use App\Models\ExampleModel;
use Interop\Container\ContainerInterface;

/**
 * Example controller class.
 * @property ExampleModel $model
 */
class ExampleController extends Controller
{
	/**
	 * ExampleController constructor.
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
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