<?php

//namespace Controllers;

use Models\Users;
use Models\Sessions;

class UsersController
{

    private $request;
    private $model;

    public function __construct($request)
    {
        
        $this->request = $request;
        $this->model = new Users();

    }

    public function run(){

        $function = strtolower($this->request->getMethod()) . ucfirst($this->request->getAction());

        if (!method_exists($this, $function)) {

            throw new Exception('Method ' . $function . ' not found', 404);

        }

        return $this->$function();

    }

    private function getUsers(){

        $users = $this->model->getUsers();

        return [
            'error' => false,
            'result' => $users
        ];

    }

    private function postRegister(){

        $data = $this->request->get();

        $data['password'] = md5($data['password']);

        $this->model->fill($data);

        $user = $this->model->save();

        unset($user['password']);

        return [
            'error' => false,
            'result' => $user
        ];

    }

    private function postLogin(){

        $data = $this->request->get();

        $data['password'] = md5($data['password']);

        $this->model->where('email', '=', $data['email']);
        $this->model->where('password', '=', $data['password']);

        $user = $this->model->first();

        if (!$user) {

            return [
                'error' => true,
                'result' => 'User not found'
            ];

        }

        unset($user['password']);

        $session = new Sessions($user);
        $session->auth();
        $user['token'] = $session->getToken();

        return [
            'error' => false,
            'result' => $user
        ];

    }

}