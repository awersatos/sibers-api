<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 18.11.17
 * Time: 15:57
 */

namespace Sibers\ApiBundle\Exceptions;

use Exception;
use Throwable;

class SibersApiException extends Exception
{
    public $response;
    public $message;

    public function __construct($message = "", $code = 0, $response,  Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = $message;
        $this->response = $response;
    }

    public function getResponce()
    {
        return $this->response;
    }
}