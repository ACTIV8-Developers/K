<?php 
namespace Core\Http;

use \Core\Util\Util;

/**
* HTTP response class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Response
{
    /**
     * List of server headers.
     * @var array
     */
    private $headers = [];

    /**
    * HTTP response body.
	* @var string 
	*/
    private $body = '';

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
    * Add or replace header.
    * @var string
    * @var bool
    */
    public function setHeader($header, $replace = true)
    {
        $this->headers[] = [$header, $replace];
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
        // Load view file
        include APPVIEW.$view.'.php';;
        // Append to output body or return string
        // (depends on function parameter $show)
        if($show) {
            // Check output level to allow nested views
            if (ob_get_level() > $this->obLevel + 1) {
                ob_end_flush();
            } else {
                $this->appendBody(ob_get_contents());
                @ob_end_clean();
            }
        } else {          
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }
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
    public function display() 
    {
        // Send headers.
        if (count($this->headers) > 0) {
            foreach ($this->headers as $header) {
                @header($header[0], $header[1]);
            }
        }
        // Send body.
        echo $this->body;
    }

    /**
     * Set Last-Modified HTTP Response Header
     *
     * Set the HTTP 'Last-Modified' header and stop if a conditional
     * GET request's `If-Modified-Since` header matches the last modified time
     * of the resource. The `time` argument is a UNIX timestamp integer value.
     * When the current request includes an 'If-Modified-Since' header that
     * matches the specified last modified time, the application will stop
     * and send a '304 Not Modified' response to the client.
     *
     * @param int $time The last modified UNIX timestamp
     * @throws \InvalidArgumentException If provided timestamp is not an integer
     */
    public function lastModified($time)
    {
        if (is_integer($time)) {
            $this['response']->setHeader('Last-Modified', gmdate('D, d M Y H:i:s T', $time));
            //$this->headers[]
            if ($time === strtotime($this['request']->getHeader('IF_MODIFIED_SINCE'))) {
                $this->halt(304);
            }
        } else {
            throw new \InvalidArgumentException('Slim::lastModified only accepts an integer UNIX timestamp value.');
        }
    }

    /**
     * Set ETag HTTP Response Header
     *
     * Set the etag header and stop if the conditional GET request matches.
     * The `value` argument is a unique identifier for the current resource.
     * The `type` argument indicates whether the etag should be used as a strong or
     * weak cache validator.
     *
     * When the current request includes an 'If-None-Match' header with
     * a matching etag, execution is immediately stopped. If the request
     * method is GET or HEAD, a '304 Not Modified' response is sent.
     *
     * @param string $value The etag value
     * @param string $type The type of etag to create; either "strong" or "weak"
     * @throws \InvalidArgumentException If provided type is invalid
     * @api
     */
    public function etag($value, $type = 'strong')
    {
        // Ensure type is correct
        if (!in_array($type, array('strong', 'weak'))) {
            throw new \InvalidArgumentException('Invalid Slim::etag type. Expected "strong" or "weak".');
        }

        // Set etag value
        $value = '"' . $value . '"';
        if ($type === 'weak') {
            $value = 'W/'.$value;
        }
        $this['response']->setHeader('ETag', $value);

        // Check conditional GET
        if ($etagsHeader = $this['request']->getHeader('IF_NONE_MATCH')) {
            $etags = preg_split('@\s*,\s*@', $etagsHeader);
            if (in_array($value, $etags) || in_array('*', $etags)) {
                $this->halt(304);
            }
        }
    }

    /**
     * Set Expires HTTP response header
     *
     * The `Expires` header tells the HTTP client the time at which
     * the current resource should be considered stale. At that time the HTTP
     * client will send a conditional GET request to the server; the server
     * may return a 200 OK if the resource has changed, else a 304 Not Modified
     * if the resource has not changed. The `Expires` header should be used in
     * conjunction with the `etag()` or `lastModified()` methods above.
     *
     * @param string|int $time If string, a time to be parsed by `strtotime()`;
     * If int, a UNIX timestamp;
     * @api
     */
    public function expires($time)
    {
        if (is_string($time)) {
            $time = strtotime($time);
        }
        $this['response']->setHeader('Expires', gmdate('D, d M Y H:i:s T', $time));
    }
}