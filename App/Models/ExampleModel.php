<?php
namespace App\Models;

use Core\Core\Model;

/**
 * Example model class.
 */
class ExampleModel extends Model
{
	public function getData()
	{
		// Return mock value (usually there is a database call here)
		return [
			'quote' => 'Everything should be made as simple as possible, but not simpler',
			'author' => 'Albert Einstein'
			];
	}
}