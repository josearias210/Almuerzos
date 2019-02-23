<?php

namespace Alegra\Helpers;

class Result {

    public $success;
    public $code;
    public $message;
    public $data;

    public function __construct($success, $code, $message = null, $data = null) {
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

}
