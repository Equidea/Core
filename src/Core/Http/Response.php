<?php

namespace Equidea\Core\Http;

use Equidea\Core\Http\Interfaces\ResponseInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Core\Http
 */
class Response implements ResponseInterface {

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    public static $mimeTypes = [
        'html' => 'text/html',
        'json' => 'application/json'
    ];

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    public static $reasonPhrases = [
        // 1xx Informational
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        // 2xx Sucess
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        // 3xx Redirection
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        // 4xx Client Error
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        // 5xx Server Error
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required'
    ];

    /**
     * @param   int     $code
     */
    public function __construct(int $code) {
        $this->code = $code;
    }

    /**
     * Creates a default code 200 (OK) HTML (text/html) Response with an empty
     * body from the $_SERVER global variable.
     *
     * @return  \Equidea\Http\Interfaces\ResponseInterface
     */
    public static function createDefaultHtml() : ResponseInterface
    {
        $default = new static(200);

        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ?
            $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';

        $default->setProtocol($protocol);
        $default->setType(self::$mimeTypes['html']);
        $default->setBody('');

        return $default;
    }

    /**
     * @return  string
     */
     public function getProtocol() : string {
         return $this->protocol;
     }

    /**
     * @return  int
     */
    public function getCode() : int {
        return $this->code;
    }

    /**
     * @return  int
     */
    public function getMessage() : string {
        return self::$reasonPhrases[$this->code];
    }

    /**
     * @return  string
     */
    public function getType() : string {
        return $this->type;
    }

    /**
     * @return  string
     */
    public function getBody() : string {
        return $this->body;
    }

    /**
     * @param   string  $protocol
     *
     * @return  self
     */
    public function withProtocol(string $protocol)
    {
        $clone = clone $this;
        $clone->protocol = $protocol;
        return $clone;
    }

    /**
     * @param   int $code
     *
     * @return  self
     */
    public function withCode(int $code)
    {
        $clone = clone $this;
        $clone->code = $code;
        return $clone;
    }

    /**
     * @param   string  $type
     *
     * @return  self
     */
    public function withType(string $type)
    {
        $clone = clone $this;
        $clone->setType($type);
        return $clone;
    }

    /**
     * @param   string  $body
     *
     * @return  self
     */
    public function withBody(string $body)
    {
        $clone = clone $this;
        $clone->setBody($body);
        return $clone;
    }

    /**
     * @param   string  $protocol
     *
     * @return  void
     */
    public function setProtocol(string $protocol) {
        $this->protocol = $protocol;
    }

    /**
     * @param   string  $body
     *
     * @return  void
     */
    public function setBody(string $body) {
        $this->body = $body;
    }

    /**
     * @param   string  $type
     *
     * @return  void
     */
    public function setType(string $type) {
        $this->type = $type;
    }

    /**
     * @param   string  $location
     *
     * @return  void
     */
    public function redirect(string $location)
    {
        header('Location: '.$location);
        exit;
    }
}
