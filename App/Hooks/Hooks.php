<?php
/*
|--------------------------------------------------------------------------
| Definitions of all hooks comes here.
|--------------------------------------------------------------------------
*/
$app->setHook('before.routing', function($app) {
	detectLanguage($app);
});

/**
* Example hook.
* Extract language from given URI and put it into constant,
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

	$lang = $app['request']->getUriSegment(0);
	if (in_array($lang, $languages['languages'])) {
		define('LANG', $lang);
	} else {
		define('LANG', $languages['default']);
	}
}