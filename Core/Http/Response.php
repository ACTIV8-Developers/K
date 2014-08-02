<?php 
namespace Core\Http;

use \Core\Util\Util;

/**
* HTTP response class.
* This class provides simple abstraction over top an HTTP response. 
* This class provides methods to set the HTTP status, the HTTP headers,
* the HTTP body and also handles 'Views' rendering.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Response
{
     /**
     * HTTP response codes and messages
     * @var array 
     */
    private static $messages = [
        //Informational 1xx
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        //Successful 2xx
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        //Redirection 3xx
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',
        //Client Error 4xx
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
        //Server Error 5xx
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported'
    ];
    
    /**
     * List of HTTP headers to be sent.
     * @var array
     */
    private $headers = [];

    /**
    * HTTP response body.
	* @var string 
	*/
    private $body = '';

    /**
    * HTTP response code.
    * @var int
    */
    private $statusCode = 200;

    /**
    * HTTP protocol version.
    * @var string
    */
    private $statusProtocol = '';

    /**
     * Nesting level of the output buffering mechanism.
     * @var int
     */
    private $obLevel;

    /**
    * Class constructor.
    */
    public function __construct()
    {
        $this->obLevel = ob_get_level();
    }

    /**
    * Add or replace header.
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
    * @return array
    */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
    * Set HTTP response body.
    * @var string
    */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
    * Append to HTTP response body.
    * @var string
    */
    public function appendBody($part)
    {
        $this->body .= $part;
    }

    /**
    * Get HTTP response body.
    * @return string
    */
    public function getBody()
    {
        return $this->body;
    }

    /**
    * Set HTTP response code to be sent with headers.
    * @var int
    */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
    }

    /**
    * Get HTTP response code.
    * @return int
    */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
    * Set server protocol.
    * @return string
    */
    public function setStatusProtocol($protocol)
    {
        return $this->serverProtocol = $protocol;
    }

    /**
    * Name and revision of the information protocol via which the page was requested; i.e. 'HTTP/1.0'.
    * @param string
    */
    public function getStatusProtocol()
    {
        if (!isset($this->serverProtocol)) {
            $this->serverProtocol = $_SERVER['SERVER_PROTOCOL'];
        }
        return $this->serverProtocol;
    }

    /**
    * Buffer output or return it as string.
    * @param string
    * @param array
    * @param bool
    * @return string|null
    */
    public function render($view, $data = [], $display = true)
    {
        // Extract variables
        extract($data);
        // Start buffering
        ob_start();
        // Load view file (root location is declared in APPVIEW constant)
        include APPVIEW.$view.'.php';
        // Append to output body or return string
        // (depends on function parameter $display)
        if ($display) {
            // Check output level to allow nested views
            if (ob_get_level() > $this->obLevel + 1) {
                ob_end_flush();
            } else {
                $this->body .= ob_get_contents();
                @ob_end_clean();
            }
        } else {          
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }
    }

    /**
     * Set response type to JSON.
     * @param array
     * @param int
     * @param int
     */
    public function sendJSON($value, $options = 0)
    {
        $this->headers[] = ["Content-Type: application/json", true];
        $this->body = json_encode($value, $options);
    }

    /**
    * Redirect helper function.
    * @var string
    * @var int 
    */
    public function redirect($url = '', $statusCode = 303)
    {
        header('Location: '.Util::base($url), true, $statusCode);
        die();
    }

    /**
    * Send final content and headers.
    */
    public function send()
    {
        // Check if headers are sent already.
        if (headers_sent() === false) {

            // Send status code
            header(sprintf('%s %s', $this->getStatusProtocol(), self::$messages[$this->statusCode]), true, $this->statusCode);
            
            // Send headers.
            if (count($this->headers) > 0) {
                foreach ($this->headers as $header) {
                    @header($header[0], $header[1], $this->statusCode);
                }
            }

            // Send body.
            echo $this->body;
        }
    }
}