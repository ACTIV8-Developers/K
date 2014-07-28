<?php
namespace Core\Util\Facades;

class SessionFacade extends Facade
{
	protected static function getName() 
	{ 
		return 'session'; 
	}
}