<?php
namespace Core\Util\Facades;

class DbFacade extends Facade
{
	protected static function getName() 
	{ 
		return 'dbdefault'; 
	}
}