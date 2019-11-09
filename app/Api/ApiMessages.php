<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 08/11/2019
 * Time: 20:37
 */

namespace App\Api;


class ApiMessages
{

    private $message = [];

    public function __construct(strin $message, array $data = [])
    {
        $this->message['message'] = $message;
        $this->message['errors'] = $data;
    }

    public function getMessage()
    {
        return $this->message;
    }
}