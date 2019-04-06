K
=
[![Build Status](https://travis-ci.org/Kajna/K-Core.svg)](https://travis-ci.org/Kajna/K-Core)
[![Version](https://img.shields.io/badge/version-3.2.0-orange.svg)](https://packagist.org/packages/kajna/k-framework)
[![DUB](https://img.shields.io/dub/l/vibe-d.svg)](http://opensource.org/licenses/MIT)

## Introduction

K is simple mini framework, made with simplicity and performance in mind. This is template app repository, if you want to explore how internals work or contribute core files can be found [here](https://github.com/Kajna/K-Core)

# Getting started

### Install

K requires PHP **>=5.4** and [Composer](https://getcomposer.org/) dependency manager to run.

So, before using K, you will need to make sure you have Composer installed on your machine

To install K using composer run following command:
```
composer create-project kajna/k-framework projectname --prefer-dist
```
### Setup web server

#### Apache

K uses front end controller pattern so ensure the .htaccess and index.php files are in the same public-accessible directory. The .htaccess file should contain at least this code (K ships with example .htaccess file that can be used):

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /index.php [QSA,L]
```

Additionally, make sure virtual host is configured with the AllowOverride option so that the .htaccess rewrite rules can be used:

AllowOverride All

#### Nginx

The nginx configuration file should contain at least this code in your location block:

    try_files $uri $uri/ /index.php?$args;

This assumes that index.php is in the root folder of your project (www root).

# Architecture Foundations

## Application structure

Application consists of bootstrap index.php file and App folder. App folder will usually hold all user files as configuration, controllers, models, views, middleware, hooks etc. Althought not required App folder will come with predefined folder structure:

*   Config
*   Controllers
*   Hooks
*   Middleware
*   Models
*   Views

## Application lifecycle

The entry point for all requests to a K application is the index.php file. All requests are directed to this file by your web server (Apache / Nginx) configuration. The index.php file doesn't contain much code. Rather, it is simply a starting point for loading the rest of the framework.

The index.php file loads the Composer generated auto loader definition, and then retrieves an instance of the K application **Core** class. When **Core** class is instantiated optionally midlewares and hooks are added and then execute method is called to start generating response.

K has middleware based architecture that means that each added middleware is executed before calling routing process which is itself middleware also.

After all middleware are executed and targeted route is found (or not), application generated response is displayed back to user.

# The Basics

## Routing

#### Basic routes

All routes are declared in file App/routes.php file. The most basic K route simply accepts a URI and two strings representing name of class and name of class method to execute:
```php
$route->get('contact', "ExampleController", "contactAction"); 
$route->post('contact', "ExampleController", "contactPostAction"); 
```

#### Routes with parameters

Sometimes you will need to capture segments of the URI within your route. For example, when article ID is passed in the URL you may capture it by defining route parameters:
```php
$route->get('article/:id', ArticleController::class, "getArticleAction"); 
```

Captured ID will be appended to **Request** object get array

#### Available Router Methods

The router allows you to register routes that respond to any HTTP verb:
```php
$route->get($uri, $controller, $method);
$route->post($uri, $controller, $method);
$route->put($uri, $controller, $method);
$route->patch($uri, $controller, $method);
$route->delete($uri, $controller, $method);
$route->options($uri, $controller, $method);
```

## Middleware

#### What is middleware?

Middleware is a anything that is callable and accepts another callable as parameter (next middleware on stack):

Middleware can do any task like start session, filter request, connect to database, etc. The only hard requirement is that a middleware MUST return an instance of **Response**. Each middleware SHOULD invoke the next middleware.

#### How does middleware work?

Different frameworks use middleware differently. K implements middleware as stack. Each new middleware will be put on top of existing middleware. The structure expands as additional middleware layers are added. The last middleware layer added is the first to be executed. By default application core routing process will be automatically added as middleware.

When K application is executed middleware stack is popped and first element is invoked which will either return **Response** or invoke next middleware and so on. When middleware stack is executed application will render returned response and will display it back to user.

#### How to write middleware?

##### Closure middleware example
```php
function ($next) {
    // Do something

    return $next();
};
```

##### Invokable class middleware example

This example middleware is an invokable class that implements the magic __invoke() method.
```php
class ExampleMiddleware
{
    public function __invoke($next)
    {
        // Do something

        return $next();
    }
}
```

#### How do I add middleware?

You may add middleware to a K application or to an individual K application route. All scenarios accept the same middleware and implement the same middleware interface.

#### Application middleware

Application (global) middleware will be executed on any request.
```php
$app
->addMiddleware(new App\Middleware\SessionMiddleware())
->addMiddleware(new App\Middleware\RegistryMiddleware());
```

#### Route middleware

You can also attach middleware to any route and it will be invoked only when route is matched.
```php
$route->get('foo', 'Foo', 'Bar')->addMiddleware(function($next) {});
```

#### Route group middleware
Middleware can be attached to group of routes as well:
```php
$route->group(API_PREFIX, function($route) {
    $route->get('data/list', DataController::class, 'getList');
}, [
    new \App\Middleware\JSONParserMiddleware($container),
    new \App\Middleware\AuthMiddleware($container)
]);
```

## Hooks

#### What is a hook?

A "hook" is a moment in the K application lifecycle at which a callable assigned to the hook will be invoked if present. A hook is identified by a string name.

Although middleware can be used in most cases, some specific events will require hooks, currently K supports hooks for following events:

*   Route not found (not.found)
*   Exception cached (internal.error)
*   After application response is sent (after.execute)

Example for setting hook which will be invoked when exception is thrown.
```php
$app->setHook('internal.error', (new App\Hooks\InternalErrorHook())->setContainer($container));
```

## Controllers

K's Controller class provides many useful methods for accessing container objects and extending route target classes by Controller class is preferred way of doing things.

#### Container access

K injects container object to every class route that extends ContainerAware class (which Controller class does). Content of container can be accesed in different ways:
```php
// Get via magic method
$request = $this->request;

// Get through array access operator on injected container object
$request = $this->container['request']; 

// Register class in container 
$this->container['classname'] = function() { 
     return new ClassName(); 
}; 
```

#### Render/Buffer template:

Though not a requirement, most controllers will ult imately render a template that's responsible for generating the HTML (or other format). Templates are usually stored in App/Views folder.
```php
$response = $this->render('ViewName', $dataToBeSent);
$view = $this->buffer('ViewName', $dataToBeSent);
```

Note that render method will return **Response** object

#### Controller example
```php
namespace App\Controllers;

use Core\Core\Controller;
use App\Models\ExampleModel;

/**
 * Example controller class.
 * @property ExampleModel $model
 */
class ExampleController extends Controller
{
    /**
     * Example method I.
     */
    public function indexAction()
    {
        // Get data from model class 
        // (when accesing undeclared object in controller container will be checked for specific key,
        // in this case we assume model is registered in container somewhere else)
        $data['content'] = $this->model->getData();

        // Render method will buffer view with passed data and write it to Response class for final output
        return $this->render('ExampleView', $data);
    }
    
    /**
     * Example method II.
     */
    public function testAction()
    {
        return (new Response())->setStatusCode(200)->setBody('<div>Hello World</div>');
    }
}
```

## Request

**Request** object is created in K boot process and can be obtained from application container as described in controllers section.

Examples of commonly used request methods:
```php
// Gets foo GET var. 
$foo = $request->get->get('foo'); 
// Gets POST var. 
$bar = $request->post->get('bar');  
// Get request method. 
$method = $request->getMethod(); 
// Retrieve a COOKIE value 
$request->cookies->get('PHPSESSID');
// Gets the URI. 
$uri = $request->getUri(); 
// Server variables. 
$host = $request->server->get('HTTP_HOST'); 
// File posted in a form. 
$file = $request->files->get('file'); 
// Get one of request headers. 
$type = $request->headers->get('CONTENT_TYPE'); 
// Cookies 
$id = $request->cookies->get('PHPSESSID'); 
// Check if it is AJAX request. 
$isAjax = $request->isAjax(); 
// Check if it is POST request.  
$isPost = $request->isPost();
```
## Response

Every middleware or route callback is expected to return **Response** object, by default K will not create any response and it expected that response is created during application runtime and passed back.

Examples of commonly used response methods:

```php
$response->setHeader('Content-type', 'application/pdf'); 
$response->setCookie('lang', 'en'); 
$response->setProtocolVersion('HTTP/1.1'); 
$response->setStatusCode(200);
// Append to output body.
$response->writeBody('');
// Set output body.
$response->setBody(''); 
```

### Author
Author of framework is Milos Kajnaco 
milos@caenazzo.com

### Licence
The K Framework is released under the [MIT](http://opensource.org/licenses/MIT) public license.
