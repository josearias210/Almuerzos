<?php

namespace Alegra\Helpers;

use Alegra\Helpers\Result;

class ApiResponse {

    public function json(Result $resultado) {
         
        if ($resultado->success == true) {
            return response()->json($resultado->data, $resultado->code);
        } else {
            return response()->json(["message" => $resultado->message], $resultado->code);
        }
          
    }

    public static function instance() {
        return new ApiResponse();
    }

}
