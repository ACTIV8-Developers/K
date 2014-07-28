<?php
/*
| -------------------------------------------------------------------
| Class aliases for easier use and cleaner code.
| -------------------------------------------------------------------
*/
return [
	'Core'		=>'Core\Core\Core',
	'Route'		=>'Core\Routing\Router',
	'Controller'=>'Core\Core\BaseController',
	'Model'		=>'Core\Core\BaseModel',
	'Security'	=>'Core\Util\Security',
	'Util'		=>'Core\Util\Util',
	'Log'		=>'Core\Util\Log',
    'Message'   =>'Core\Util\Message',
    // Facades
    'Input'     =>'Core\Util\Facades\InputFacade',
    'Session'   =>'Core\Util\Facades\SessionFacade',
];