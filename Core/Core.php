<?php

use Core\Response;

class Core {

    private $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function run() {

        $controller = $this->request->getController();
        
        if (file_exists('Controllers/' . $controller . '.php')) {

            require_once $_SERVER['DOCUMENT_ROOT'] . '/Controllers/' . $controller . '.php';
            //die($_SERVER['DOCUMENT_ROOT'] . '/controllers/' . $controller . '.php');

            if (!class_exists($controller)) {

                throw new Exception('Controller ' . $controller . ' not found', 404);

            }
            
            $controller = new $controller($this->request);

            return new Response($controller->run());

        }

    }

}
