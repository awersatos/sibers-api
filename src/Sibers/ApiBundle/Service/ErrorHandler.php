<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 19.11.17
 * Time: 18:25
 */

namespace Sibers\ApiBundle\Service;

use Symfony\Component\HttpFoundation\Response;

class ErrorHandler
{
    public $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function getResponse($code, $subCode, $message = '', $decr = '')
    {
        if (isset($this->errors[$code][$subCode])) {
            $name = $this->errors[$code][$subCode]['name'];
            $description = $this->errors[$code][$subCode]['description'];
        } else {
            $name = $message;
            $description = $decr;
        }

        $result['status'] = 'error';
        $result['errors'][] = [
            'code' => $subCode,
            'name' => $name,
            'description' => $description
        ];

        $response = new Response();
        $response->setContent(json_encode($result))->setStatusCode($code);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}