<?php

class Request{

    private $uri;
    private $controller;
    private $action;
    private $parameters;
    private $method;

    public function __construct(){

        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->splitURI();

    }

    private function splitURI(){

        $pieces = explode('/', $this->uri);
        
        if (count($pieces) > 1) {

            $this->controller = ucfirst($pieces[1]).'Controller';

            if (count($pieces) > 2) {
                $this->action = $pieces[2];
            }else{
                $this->action = 'index';
            }

            if (count($pieces) > 3) {
                $this->parameters = array_slice($pieces, count($pieces) - 3);
            }

            return true;

        }

        $this->controller = 'main';

    }

    public function getController(){

        return $this->controller;

    }

    public function getAction(){

        return $this->action;

    }

    public function getParameters(){

        return $this->parameters;

    }

    public function getMethod(){

        return $this->method;

    }

    public function get(){

        $result = [];

        foreach ($_POST as $key => $value) {
            $result[$key] = $value;
        }

        return $result;

    }

}