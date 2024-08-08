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

        if (is_numeric($this->request->getAction())){

            $this->request->setParameters([$this->request->getAction()]);
            $this->request->setAction('user');

        }

        $function = strtolower($this->request->getMethod()) . ucfirst($this->request->getAction());

        if (!method_exists($this, $function)) {

            throw new Exception('Method ' . $function . ' not found', 404);

        }

        return $this->$function();

    }

    private function getIndex(){

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

    private function getUser(){

        $id = $this->request->getParameters()[0];

        $this->model->where('id', '=', $id);

        $user = $this->model->first();

        if (!$user) {

            return [
                'error' => true,
                'result' => 'User not found'
            ];

        }

        unset($user['password']);

        return [
            'error' => false,
            'result' => $user
        ];
    }

    private function deleteUser(){

        $id = $this->request->getParameters()[0];

        $this->model->where('id', '=', $id);

        $user = $this->model->first();

        if (!$user) {

            return [
                'error' => true,
                'result' => 'User not found'
            ];

        }

        $this->model->delete();

        return [
            'error' => false,
            'result' => 'User deleted'
        ];

    }

}