<?php

//namespace Controllers;

use Models\Users;

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

        $this->model->fill($this->request->get());

        $data = $this->model->save();

        return $data;

    }

}