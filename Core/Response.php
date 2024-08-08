<?php

namespace Core;

class Response{

    public function __construct($data){ 

        header('Content-Type: application/json');
        
        if (!$data['error']){

            http_response_code($data['code'] ?? 200);

            echo json_encode($data['result']);            

        }else{

            http_response_code($data['code'] ?? 500);

            echo json_encode($data['result']);

        }

        exit();

    }

}