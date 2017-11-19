<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 19.11.17
 * Time: 18:25
 */

namespace Sibers\ApiBundle\Service;


class ErrorHandler
{
    public $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }
}