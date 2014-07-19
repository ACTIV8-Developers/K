<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>K framework</title>
      <style>
          body {
              width: 100%;
              height: 100%;
              font-family: "Courier New", Courier, monospace;
          }
          #page {
              position: relative;
              width: 960px;
              margin: 0 auto;
          }
      </style>
  </head>
  <body id="page">
        <div>
            <h1>Welcome to home of K framework</h1>
        </div>
        <hr>
        <article>
        
        <h2><?=$content;?></h2>

        <blockquote>
        <p><em>Everything should be made as simple as possible, but not simpler</em> 
        <strong> - Albert Einstein</strong></p>
        </blockquote>

        <h2>
        <a><span></span></a>Getting started</h2>

        <h3>
        <a><span></span></a>Install</h3>

        <p>K requires PHP <strong>&gt;=5.4</strong> and <a href="https://getcomposer.org/">Composer</a> to run.</p>

        <p>To install K <a href="https://github.com/Kajna/K" target="_blank"><strong>download</strong></a> and extract files in working directory then run <em>composer update</em> command.</p>

        <h3>
        <a><span></span></a>Setup web server</h3>

        <h4>
        <a><span></span></a>Apache</h4>

        <p>K uses front end controller pattern so ensure the .htaccess and index.php files are in the same public-accessible directory. The .htaccess file should contain at least this code (K ships with example .htaccess file that can be used):</p>

        <pre><code>RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ /index.php [QSA,L]
        </code></pre>

        <p>Additionally, make sure virtual host is configured with the AllowOverride option so that the .htaccess rewrite rules can be used:</p>

        <p>AllowOverride All</p>

        <h4>
        <a><span></span></a>Nginx</h4>

        <p>The nginx configuration file should contain at least this code in your location block:</p>

        <pre><code>try_files $uri $uri/ /index.php?$args;
        </code></pre>

        <p>This assumes that index.php is in the root folder of your project (www root).</p>

        <h2>
        <a><span></span></a>Documentation</h2>

        <p>Work in progress. Coming soon :)</p>

        <h2>
        <a><span></span></a>Author</h2>

        <p>Author of framework is Milos Kajnaco 
        <a href="mailto:miloskajnaco@gmail.com">miloskajnaco@gmail.com</a></p>
        <p>Member of <a target="blank" href="http://codejam.co/">Codejam</a></p>

        <h2>
        <a><span></span></a>Licence</h2>

        <p>The K Framework is released under the <a href="http://opensource.org/licenses/MIT">MIT</a> public license.</p></article>
        </div>
  </body>
</html>