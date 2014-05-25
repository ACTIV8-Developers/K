<?php
/*
|--------------------------------------------------------------------------
| Definitions of all hooks comes here.
|--------------------------------------------------------------------------
*/
$app->hook('before.routing', function($app) {
	/*
	|--------------------------------------------------------------------------
	| Language support list
	|--------------------------------------------------------------------------
	*/
	$languages = [
	    'default'=>'latin',
	    'languages'=>['en', 'cyr']
    ];
	/**
	* Extract language from given URI and put it into global variable,
	*/
	$parts = explode('/', $app['request']->getUri(), 2);
	if(in_array($parts[0], $languages['languages'])) {
		define('LANG', $parts[0]);
	} else {
		define('LANG', $languages['default']);
	}
});