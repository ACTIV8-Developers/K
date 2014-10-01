<?php 
namespace Core\Http;

/**
* HTTP response class.
*
* This class provides simple abstraction over top an HTTP response. 
* This class provides methods to set the HTTP status, the HTTP headers,
* the HTTP cookies and the HTTP body.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Response
{
     /**
     * HTTP response codes and messages.
     *
     * @var array 
     */
    protected static $messages = [
        // Informational 1xx.
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        // Successful 2xx.
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        // Redirection 3xx.
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',
        // Client Error 4xx.
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        418 => '418 I\'m a teapot',
        422 => '422 Unprocessable Entity',
        423 => '423 Locked',
        // Server Error 5xx.
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported'
    ];
    
    /**
    * HTTP response protocol version.
    *
    * @var string
    */
    protected $protocolVersion = 'HTTP/1.1';

    /**
    * HTTP response code.
    *
    * @var int
    */
    protected $statusCode = 200;

    /**
     * List of HTTP headers to be sent.
     *
     * @var array
     */
    protected $headers = [];

    /**
    * HTTP response body.
    *
    * @var string 
    */
    protected $body = '';

    /**
    * Array of cookies to be sent.
    *
    * @var array
    */
    protected $cookies = [];

    /**
    * Add or replace header.
    *
    * @var string
    * @var string
    * @var bool
    */
    public function setHeader($header, $value, $replace = true)
    {
        $this->headers[] = [$header.': '.$value, $replace];
    }

    /**
    * Return array of headers.
    *
    * @return array
    */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
    * Set HTTP response body.
    *
    * @var string
    */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
    * Append to HTTP response body.
    *
    * @var string
    */
    public function writeBody($part)
    {
        $this->body .= $part;
    }

    /**
    * Get HTTP response body.
    *
    * @return string
    */
    public function getBody()
    {
        return $this->body;
    }

    /**
    * Set HTTP response code to be sent with headers.
    *
    * @var int
    */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
    }

    /**
    * Get HTTP response code.
    *
    * @return int
    */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
    * Get HTTP protocol version.
    *
    * @return string
    */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
    * Set HTTP protocol version ("HTTP/1.1" or "HTTP/1.0").
    *
    * @param string 
    */
    public function setProtocolVersion($version)
    {
        $this->protocolVersion = $version;
    }

    /**
    * Send cookie with response.
    *
    * @param string   
    * @param string  
    * @param int|string|\DateTime
    * @param string
    * @param string
    * @param bool                    
    * @param bool
    * @throws \InvalidArgumentException
    */
    public function setCookie($name, $value = null, $expire = 7200, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        // As stated in PHP source code.
        if (preg_match("/[=,; \t\r\n\013\014]/", $name)) {
            throw new \InvalidArgumentException(sprintf('The cookie name "%s" contains invalid characters.', $name));
        }

        // Convert expiration time to a Unix timestamp.
        if ($expire instanceof \DateTime) {
            $expire = $expire->format('U');
        } elseif (!is_numeric($expire)) {
            $expire = strtotime($expire);
            if (false === $expire || -1 === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.');
            }
        } else {
            $expire = time() + $expire;
        }

        $this->cookies[] = ['name'     => $name, 
                            'value'    => $value, 
                            'expire'   => $expire, 
                            'path'     => $path, 
                            'domain'   => $domain, 
                            'secure'   => (bool)$secure, 
                            'httponly' => (bool)$httpOnly
                            ];
    }

    /**
     * Set response type to JSON.
     *
     * @param array
     * @param int
     * @param int
     */
    public function json($value, $options = 0)
    {
        $this->headers[] = ['Content-Type: application/json', true];
        $this->body = json_encode($value, $options);
    }

    /**
    * Send final headers, cookies and content.
    */
    public function send()
    {
        // Check if headers are sent already.
        if (headers_sent() === false) {

            // Send status code.
            header(sprintf('%s %s', $this->protocolVersion, self::$messages[$this->statusCode]), true, $this->statusCode);
            
            // Send headers.
            foreach ($this->headers as $header) {
                header($header[0], $header[1], $this->statusCode);
            }

            // Send cookies.
            foreach ($this->cookies as $cookie) {
                setcookie($cookie['name'], $cookie['value'], $cookie['expire'], 
                    $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);
            }

            // Send body.
            echo $this->body;
        }
    }
}