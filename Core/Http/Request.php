<?php
namespace Core\Http;

/**
* HTTP request class.
*
* This class provides interface for common request parameters.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Request
{
    /**
    * List of possible HTTP request methods.
    */
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    /**
    * Server and execution environment parameters (parsed from $_SERVER).
    * @var object \Bag
    */
    public $server;

    /**
    * Request headers (parsed from the $_SERVER).
    * @var object \Bag
    */
    public $headers;

    /**
    * Request parameters (parsed from the $_GET).
    * @var object \Bag
    */
    public $get;

    /**
    * Request parameters (parsed from the $_POST).
    * @var object \Bag
    */
    public $post;

    /**
    * Request cookies (parsed from the $_COOKIE).
    * @var object \Bag
    */
    public $cookies;

    /**
    * Request files (parsed from the $_FILES).
    * @var object \Bag
    */
    public $files;

    /**
    * Raw request content.
    * @var string
    */
    private $content = null;

    /**
    * Request method.
    * @var string
    */
    private $method = null;
    
    /**
    * Class constructor.
    * @param array
    * @param array
    * @param array
    * @param array
    * @param array
    */
    public function __construct(array $server = [], array $get = [], array $post = [], array $cookies = [], array $files = [])
    {
        // Fix URI if neeeded.
        if (strpos($server['REQUEST_URI'], $server['SCRIPT_NAME']) === 0) {
            $server['REQUEST_URI'] = substr($server['REQUEST_URI'], strlen($server['SCRIPT_NAME']));
        } elseif (strpos($server['REQUEST_URI'], dirname($server['SCRIPT_NAME'])) === 0) {
            $server['REQUEST_URI'] = substr($server['REQUEST_URI'], strlen(dirname($server['SCRIPT_NAME'])));
        }
        $server['REQUEST_URI'] = trim($server['REQUEST_URI'], '/');

        $this->method = $server['REQUEST_METHOD'];

        $this->headers = new HttpBag();
        $this->server = new HttpBag();

        // Parse request headers and enviroment variables.
        $specialHeaders = ['CONTENT_TYPE', 'CONTENT_LENGTH', 'PHP_AUTH_USER', 'PHP_AUTH_PW', 'PHP_AUTH_DIGEST', 'AUTH_TYPE'];
        foreach ($server as $key => $value) {
            $key = strtoupper($key);
            if (strpos($key, 'HTTP_') === 0 || in_array($key, $specialHeaders)) {
                if ($key === 'HTTP_CONTENT_TYPE' || $key === 'HTTP_CONTENT_LENGTH') {
                    continue;
                }
                $this->headers->set($key, $value);
            } else {
                $this->server->set($key, $value);
            }
        }

        // Since PHP doesn't support PUT, DELETE, PATCH naturally we will parse data directly from source.
        if (0 === strpos($this->headers->get('CONTENT_TYPE'), 'application/x-www-form-urlencoded')
            && in_array($this->method, array('PUT', 'DELETE', 'PATCH'))) {
            parse_str($this->getContent(), $data);
            $this->post = new HttpBag($data);
        } else {
            $this->post = new HttpBag($post); 
        }

        $this->get = new HttpBag($get);
        $this->cookies = new HttpBag($cookies); 
        $this->files = new HttpBag($files); 
    }

    /**
    * Get raw request input.
    * @return string
    */
    public function getContent()
    {
        if (null === $this->content) {
            $this->content = file_get_contents('php://input');
        }
        return $this->content;
    }

    /**
    * Get request uri.
    * @return string
    */
    public function getUri()
    {
        return $this->server->get('REQUEST_URI');
    }

    /**
    * Get request URI segment.
    * @param int
    * @return string|bool
    */
    public function getUriSegment($num)
    {
        $segments = explode('/', $this->server->get('REQUEST_URI'));
        if (isset($segments[$num])) {
            return $segments[$num];
        }
        return false;
    }

    /**
     * Get server protocol (eg. HTTP/1.1.)
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->server->get('SERVER_PROTOCOL');
    }

    /**
    * Check if it is AJAX request.  
    * @return bool
    */
    public function isAjax()
    {
        if (!empty($this->server->get('HTTP_X_REQUESTED_WITH')) 
            && strtolower($this->server->get('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
    * Get request method.
    * (GET, POST, PUT, DELETE etc.)
    * @return string
    */
    public function getRequestMethod()
    {
        return $this->method;
    }

    /**
    * Check if it is HEAD request.  
    * @return bool
    */
    public function isHead()
    {
        return self::METHOD_HEAD === $this->method;
    }

    /**
    * Check if it is GET request.  
    * @return bool
    */
    public function isGet()
    {
        return self::METHOD_GET === $this->method;
    }

    /**
    * Check if it is POST request.  
    * @return bool
    */
    public function isPost()
    {
        return self::METHOD_POST === $this->method;
    }

    /**
    * Check if it is PUT request.  
    * @return bool
    */
    public function isPut()
    {
        return self::METHOD_PUT === $this->method;
    }

    /**
    * Check if it is PATCH request.  
    * @return bool
    */
    public function isPatch()
    {
        return self::METHOD_PATCH === $this->method;
    }

    /**
    * Check if it is PUT request.  
    * @return bool
    */
    public function isDelete()
    {
        return self::METHOD_DELETE === $this->method;
    }

    /**
    * Check if it is OPTIONS request.  
    * @return bool
    */
    public function isOptions()
    {
        return self::METHOD_OPTIONS === $this->method;
    }

    /**
    * Get user agent.
    * @return string|null
    */
    public function getUserAgent()
    {
        return $this->header->get('HTTP_USER_AGENT');
    }

    /**
    * Get referer.
    * @return string|null
    */
    public function getReferer()
    {
        return $this->header->get('HTTP_REFERER');
    }

    /**
    * Get content type.
    * @return string|null
    */
    public function getContentType()
    {
        return $this->header->get('CONTENT_TYPE');
    }

    /**
    * Get content length.
    * @return string|null
    */
    public function getContentLength()
    {
        return $this->header->get('CONTENT_LENGTH');
    }
}