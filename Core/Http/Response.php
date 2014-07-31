<?php 
namespace Core\Http;

use \Core\Util\Util;

/**
* HTTP response class.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Response
{
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
    * Get HTTP response body.
    * @return string
    */
    public function getBody()
    {
        return $this->body;
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
    * Buffer output or return it as string.
    * @param string
    * @param array
    * @param bool
    * @return string | null
    */
    public function render($view, $data = [], $show = true)
    {
        // Extract variables
        extract($data);
        // Start buffering
        ob_start();
        // Load view file (root location is declared in APPVIEW constant)
        include APPVIEW.$view.'.php';
        // Append to output body or return string
        // (depends on function parameter $show)
        if($show) {
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
        header('Location: '.Util::baseUrl($url), true, $statusCode);
        die();
    }

    /**
    * Send final content and headers.
    */
    public function send()
    {
        // Check if headers are sent already.
        if (!headers_sent()) {
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