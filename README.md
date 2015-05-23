K
=
[![Build Status](https://travis-ci.org/Kajna/K-Core.svg)](https://travis-ci.org/Kajna/K-Core)
[![Version](https://img.shields.io/badge/version-2.0.0-orange.svg)](https://packagist.org/packages/kajna/k-framework)
[![DUB](https://img.shields.io/dub/l/vibe-d.svg)](http://opensource.org/licenses/MIT)

Simple and lightweight yet powerfull PHP framework
> *Everything should be made as simple as possible, but not simpler* 
**Albert Einstein**

###This is template app repository, core files can be found [here](https://github.com/Kajna/K-Core)

Getting started
=
###Install
K requires PHP version **>=5.4** and it uses [Composer](https://getcomposer.org/) to manage it's dependencies. So, before using K, you will need to make sure you have Composer installed on your machine

To install K using composer run folowing command:
```
composer create-project kajna/k-framework --prefer-dist
```

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
More info
=
More information can be found [here](https://kframework.co)
Author
=
Author of framework is Milos Kajnaco 
milosk@caenazzo.com
Licence
=
The K Framework is released under the [MIT](http://opensource.org/licenses/MIT) public license.
