<?php

namespace Models;

use Models\Models;

class Sessions extends Models{

    private $table = 'sessions';
    private $user;

    private $token;

    public function __construct($user = false){

        $this->descriptor = $this->getModel($this->table);

        $this->user = $user;

    }

    public function auth(){

        $token = $this->generateToken();

        $data = [
            'user_id' => $this->user['id'],
            'token' => md5($token)
        ];

        $this->fill($data);

        $this->save();

        $this->token = $token;

        return $this;

    }

    public function check($token){

        $this->where('token', '=', md5($token));

        $session = $this->first();
        
        if (!$session) {
            return false;
        }
        
        return $session;

    }

    private function generateToken(){

        $str = $this->user['email'] . $this->user['id'];

        return md5($str);

    }

    public function getToken(){

        return $this->token;
        
    }

}