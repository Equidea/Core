<?php

namespace Equidea\Http;

use Equidea\Http\Interfaces\ResponseInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http
 */
class Response implements ResponseInterface {

    /**
     * @var mixed
     */
    protected $content;

    /**
     * @var int
     */
    protected $status;

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
     * @param   mixed   $content
     * @param   int     $status
     */
    public function __construct($content, int $status = 200)
    {
        $this->content = $content;
        $this->status = $status;
    }

    /**
     * @return  mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @return  int
     */
    public function getStatus() : int {
        return $this->status;
    }

    /**
     * @return  string
     */
    public function getMessage() : string {
        return self::$reasonPhrases[$this->status];
    }

    /**
     * @param   string  $content
     *
     * @return  self
     */
    public function withContent(string $content)
    {
        $clone = clone $this;
        $clone->content = $content;
        return $clone;
    }

    /**
     * @param   int $status
     *
     * @return  self
     */
    public function withStatus(int $status)
    {
        $clone = clone $this;
        $clone->status = $status;
        return $clone;
    }

    /**
     * @param   string  $location
     *
     * @return  void
     */
    public static function redirect(string $location)
    {
        header("Location: ".$location);
        exit;
    }

    /**
     * @return  void
     */
    public function send()
    {
        // Send status code
        header(
            $_SERVER['SERVER_PROTOCOL'].
            ' '.
            $this->status.
            ' '.
            $this->getMessage()
        );

        // Send response body
        echo $this->content;
    }
}
