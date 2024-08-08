<?php

namespace Models;

use Models\Models;

class Sessions extends Models{

    private $table = 'sessions';
    private $user;

    private $token;

    public function __construct($user){

        $this->descriptor = $this->getModel($this->table);

        $this->user = $user;

    }

    public function auth(){

        $token = $this->generateToken();

        $data = [
            'user_id' => $this->user['id'],
            'token' => $token
        ];

        $this->fill($data);

        $this->save();

        $this->token = $token;

        return $this;

    }

    private function generateToken(){

        $str = $this->user['email'] . $this->user['id'];

        return md5($str);

    }

    public function getToken(){

        return $this->token;
        
    }

}