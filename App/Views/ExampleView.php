<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>K | Simple PHP framework</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <style>
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            #wrapper {
                position: relative;
                width: 960px;
                margin: 0 auto;
            }
            .margina-top {
                margin-top: 50px;
            }
            .git {
                position: absolute; 
                top: -6px; 
                right: 0; 
                border: 0;
            }
            .page-title {
                color: #333;
                font-size: 50px;
                font-weight: 700;
                letter-spacing: -2px;
                line-height: 50px;
                margin: 0;
                outline: 0 none;
                padding: 50px 16px 8px;
                text-align: center;
            }
            .page-head {
                box-sizing: border-box;
                margin: 0 auto;
                max-width: 640px;
                padding: 0;
                position: relative;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <a target="blank" href="https://github.com/Kajna/K"><img class="git" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>
            <header class="page-head">
                <h1 class="page-title">Welcome to home of K</h1>
                <blockquote>
                    <p>
                        <em>Everything should be made as simple as possible, but not simpler</em> 
                     </p>
                     <p class="text-right">
                        <strong>Albert Einstein</strong>
                    </p>
                </blockquote>
            </header>

            <article>
                <h2>Getting started</h2>

                <h3>Install</h3>

                <p>K requires PHP <strong>&gt;=5.4</strong> and <a href="https://getcomposer.org/">Composer</a> dependency manager to run.</p>

                <p>So, before using K, you will need to make sure you have Composer installed on your machine</p>

                <p>To install K using composer run following command:</p>

                <pre><code>composer create-project kajna/k-framework projectname --prefer-dist</code>
                </pre>

                <h3>Setup web server</h3>

                <h4>Apache</h4>

                <p>K uses front end controller pattern so ensure the .htaccess and index.php files are in the same public-accessible directory. The .htaccess file should contain at least this code (K ships with example .htaccess file that can be used):</p>

                <pre><code>RewriteEngine On
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule ^(.*)$ /index.php [QSA,L]
                </code></pre>

                <p>Additionally, make sure virtual host is configured with the AllowOverride option so that the .htaccess rewrite rules can be used:</p>

                <p>AllowOverride All</p>

                <h4>Nginx</h4>

                <p>The nginx configuration file should contain at least this code in your location block:</p>

                <pre><code>try_files $uri $uri/ /index.php?$args;
                </code></pre>

                <p>This assumes that index.php is in the root folder of your project (www root).</p>

                <h2>Documentation</h2>

                <p><a href="http://kframework.co/documentation">Click here</a></p>

                <h2>Api</h2>

                <p><a href="http://kframework.co/api/index.html">Click here</a></p>

                <h2>Author</h2>

                <p>Author of framework is Milos Kajnaco 
                <a href="mailto:milos@caenazzo.com">milos@caenazzo.com</a></p>

                <h2>
                Licence</h2>

                <p>The K Framework is released under the <a href="http://opensource.org/licenses/MIT">MIT</a> public license.</p>
            </article>
            <p class="text-right"><em>K-Core version in use: <?=\Core\Core\Core::VERSION;?></em></p>
            </div>           
        </div>       
    </body>
</html>