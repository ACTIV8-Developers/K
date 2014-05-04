<?php
/*
|--------------------------------------------------------------------------
| DATABASE SETTINGS
|--------------------------------------------------------------------------
*/
return [
/*
|--------------------------------------------------------------------------
| PDO Fetch Style
|--------------------------------------------------------------------------
|
| By default, database results will be returned as associative array 
| however, it can be retrived in other formats.
|
|	PDO::FETCH_ASSOC: Returns an array.
|	PDO::FETCH_BOTH: Returns an array, indexed by both column-name, 
|	and 0-indexed.
|	PDO::FETCH_BOUND: Returns TRUE and assigns the values of the columns 
|	in your result set to the PHP variables to which they were bound.
|	PDO::FETCH_CLASS: Returns a new instance of the specified class.
|	PDO::FETCH_OBJ: Returns an anonymous object, with property names that 
|	correspond to the columns.
*/
'fetch' => PDO::FETCH_ASSOC,
/*
|--------------------------------------------------------------------------
| PDO Error Reporting
|--------------------------------------------------------------------------
|
|   PDO::ERRMODE_SILENT
|	PDO::ERRMODE_WARNING
|	PDO::ERRMODE_EXCEPTION
*/
'error' => PDO::ERRMODE_EXCEPTION,
/*
|--------------------------------------------------------------------------
| Default Database Connection
|--------------------------------------------------------------------------
|
| Defauly database used, it can be specified to use multitiple database
| types through database class.
| Supported types: mysql, pgsql, sqlsrv
*/
'type' => 'mysql',
/*
|--------------------------------------------------------------------------
| Database Connection Parameters
|--------------------------------------------------------------------------
|
| Each of the available database types settings, only used database 
| settings needs to be filled.
|
| All database work in K is done through the PHP PDO facilities,
| so make sure you have the driver for your particular database of
| choice installed before development begins.
*/
/*
| General settings
*/
'host'      => 'localhost',
'database'  => 'k_db',
'username'  => 'root',
'password'  => '',
/*
| MySQL
*/
'mysql' => [
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => '',
	],
/*
| PostgreSQL
*/
'pgsql' => [
	'charset'  => 'utf8',
	'prefix'   => '',
	'schema'   => 'public',
	],
/*
| SQL Server
*/
'sqlsrv' => [
	'prefix'   => '',
	]
];
