<?php
namespace Models;

use \Core\Core\Model;

/**
* Example model class.
*/
class ExampleModel extends Model
{
	public function getData()
	{
		// Return mock value (usually there is a database call here).
		return 'Simple and Lightweight but powerfull MVC framework';
	}
}