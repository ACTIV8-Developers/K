<?php

class CoreTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        // Minimal request needed information.
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '';

        // Make instance of app.
        $app = Core\Core\Core::getInstance();

        // Check if construct made all required things.
        $this->assertInstanceOf('Core\Core\Core', $app);
        $this->assertInstanceOf('Core\Http\Response', $app['response']);
        $this->assertInstanceOf('Core\Http\Request', $app['request']);
        $this->assertInstanceOf('Core\Routing\Router', $app['router']);
        $this->assertInstanceOf('Core\Session\Session', $app['session']);
    }

    public function testHooks()
    {
        // Make instance of app.
        $app = Core\Core\Core::getInstance();

        // Make some functions.
        $function1 = function($app) {
            $app['foo'] = 'bar';
        };

        $function2 = function($app) {
            $app['bar'] = 'foo';
        };

        // Make hooks.
        $app->setHook('before.routing', $function1);
        $app->setHook('after.routing', $function2);

        // Test hooks.
        $this->assertEquals($app->getHook('before.routing'), $function1);
        $this->assertEquals($app->getHook('after.routing'), $function2);
    }
}