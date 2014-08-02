<?php
/*
|--------------------------------------------------------------------------
| Definitions of all hooks comes here.
|--------------------------------------------------------------------------
*/
$app->hook('before.routing', function($app) {
	detectLanguage($app);
});

/**
* Extract language from given URI and put it into global variable,
*/
function detectLanguage($app)
{
	/*
	|--------------------------------------------------------------------------
	| Language support list
	|--------------------------------------------------------------------------
	*/
	$languages = [
	    'default'=>'en',
	    'languages'=>['sr-latin', 'sr-cyr']
    ];

	$lang = $app['request']->segment(0);
	if (in_array($lang, $languages['languages'])) {
		define('LANG', $lang);
	} else {
		define('LANG', $languages['default']);
	}
}