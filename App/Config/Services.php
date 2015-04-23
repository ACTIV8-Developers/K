<?php
/*
|--------------------------------------------------------------------------
| Here are registered are services
|--------------------------------------------------------------------------
*/
/*> Session <*/
$app->addService('Core\Session\SessionServiceProvider');
/*> Database <*/
$app->addService('Core\Database\DatabaseServiceProvider');
/*> Authentification <*/
$app->addService('Core\Auth\AuthServiceProvider');