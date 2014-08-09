<?php 
namespace Core\Http;

/**
* HTTP request class.
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
    * @var array 
    */
    private $environment = [];

    /**
    * Request headers (parsed from the $_SERVER).
    * @var array
    */
    private $headers = [];
    
    /**
    * Class constructor.
    * @param array
    */
    public function __construct(array $server = null)
    {
        // Fix URI if neeeded
        if (strpos($server['REQUEST_URI'], $server['SCRIPT_NAME']) === 0) {
            $server['REQUEST_URI'] = substr($server['REQUEST_URI'], strlen($server['SCRIPT_NAME']));
        } elseif (strpos($server['REQUEST_URI'], dirname($server['SCRIPT_NAME'])) === 0) {
            $server['REQUEST_URI'] = substr($server['REQUEST_URI'], strlen(dirname($server['SCRIPT_NAME'])));
        }
        $server['REQUEST_URI'] = trim($server['REQUEST_URI'], '/');

        // Parse request headers and server enviroment variables.
        $specialHeaders = [
            'CONTENT_TYPE',
            'CONTENT_LENGTH',
            'PHP_AUTH_USER',
            'PHP_AUTH_PW',
            'PHP_AUTH_DIGEST',
            'AUTH_TYPE'
        ];
        
        foreach ($server as $key => $value) {
            $key = strtoupper($key);
            if (strpos($key, 'HTTP_') === 0 || in_array($key, $specialHeaders)) {
                if ($key === 'HTTP_CONTENT_TYPE' || $key === 'HTTP_CONTENT_LENGTH') {
                    continue;
                }
                $this->headers[$key] = $value;
            } else {
                $this->environment[$key] = $value;
            }
        }
    }

    /**
    * Get environment variable.
    * @param string
    * @return string|null
    */
    public function getEnv($key)
    {
        return isset($this->environment[$key])?$this->environment[$key]:null;
    }

    /**
    * Get request uri.
    * @return string
    */
    public function getUri()
    {
        return $this->environment['REQUEST_URI'];
    }

    /**
    * Get request URI segment.
    * @param int
    * @return string|bool
    */
    public function getUriSegment($num)
    {
        $segments = explode('/', $this->environment['REQUEST_URI']);
        if (isset($segments[$num])) {
            return $segments[$num];
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
        return $this->environment['REQUEST_METHOD'];
    }

    /**
     * Get server protocol (eg. HTTP/1.1.)
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->environment['SERVER_PROTOCOL'];
    }

    /**
    * Check if it is AJAX request.  
    * @return bool
    */
    public function isAjax()
    {
        if (!empty($this->environment['HTTP_X_REQUESTED_WITH']) && strtolower($this->environment['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
    * Check if it is HEAD request.  
    * @return bool
    */
    public function isHead()
    {
        return self::METHOD_HEAD === $this->environment['REQUEST_METHOD'];
    }

    /**
    * Check if it is GET request.  
    * @return bool
    */
    public function isGet()
    {
        return self::METHOD_GET === $this->environment['REQUEST_METHOD'];
    }

    /**
    * Check if it is POST request.  
    * @return bool
    */
    public function isPost()
    {
        return self::METHOD_POST === $this->environment['REQUEST_METHOD'];
    }

    /**
    * Check if it is PUT request.  
    * @return bool
    */
    public function isPut()
    {
        return self::METHOD_PUT === $this->environment['REQUEST_METHOD'];
    }

    /**
    * Check if it is PATCH request.  
    * @return bool
    */
    public function isPatch()
    {
        return self::METHOD_PATCH === $this->environment['REQUEST_METHOD'];
    }

    /**
    * Check if it is PUT request.  
    * @return bool
    */
    public function isDelete()
    {
        return self::METHOD_DELETE === $this->environment['REQUEST_METHOD'];
    }

    /**
    * Check if it is OPTIONS request.  
    * @return bool
    */
    public function isOptions()
    {
        return self::METHOD_OPTIONS === $this->environment['REQUEST_METHOD'];
    }

    /**
    * Get request headers.
    * @return array
    */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
    * Get request header with give key.
    * @param string
    * @return string|null
    */
    public function getHeader($key)
    {
        return isset($this->headers[$key])?$this->headers[$key]:null;
    }

    /**
    * Get user agent.
    * @return string|null
    */
    public function getUserAgent()
    {
        return $this->getHeader('HTTP_USER_AGENT');
    }

    /**
    * Get referer.
    * @return string|null
    */
    public function getReferer()
    {
        return $this->getHeader('HTTP_REFERER');
    }

    /**
    * Get content type.
    * @return string|null
    */
    public function getContentType()
    {
        return $this->getHeader('CONTENT_TYPE');
    }

    /**
    * Get content length.
    * @return string|null
    */
    public function getContentLength()
    {
        return $this->getHeader('CONTENT_LENGTH');
    }
}