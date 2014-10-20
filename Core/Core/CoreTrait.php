<?php
namespace Core\Core;

trait CoreTrait
{
	/**
	* @var object Core
	*/
	protected $app = null;

	/**
	* @param object Core
	*/
	public function setContainer($app)
	{
		$this->app = $app;
	}
}