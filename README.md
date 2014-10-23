K
=
[![Build Status](https://travis-ci.org/Kajna/K-Core.svg)](https://travis-ci.org/Kajna/K-Core)

Simple solution for full featured MVC framework.
> *Everything should be made as simple as possible, but not simpler* 
**Albert Einstein**

Getting started
=
###Install
K requires PHP **>=5.4** and [Composer](https://getcomposer.org/) to run.

To install K download and extract files in working directory then run *composer update* command.

###Setup web server
####Apache

K uses front end controller pattern so ensure the .htaccess and index.php files are in the same public-accessible directory. The .htaccess file should contain at least this code (K ships with example .htaccess file that can be used):
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /index.php [QSA,L]
```

Additionally, make sure virtual host is configured with the AllowOverride option so that the .htaccess rewrite rules can be used:

AllowOverride All

####Nginx

The nginx configuration file should contain at least this code in your location block:
```
try_files $uri $uri/ /index.php?$args;
```

This assumes that index.php is in the root folder of your project (www root).
Documentation
=
Work in progress. Coming soon :)
Author
=
Author of framework is Milos Kajnaco 
miloskajnaco@gmail.com
Licence
=
The K Framework is released under the [MIT](http://opensource.org/licenses/MIT) public license.
