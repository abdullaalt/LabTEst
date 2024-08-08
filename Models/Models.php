<?php 

namespace Models;

use Core\DB;

abstract class Models{

    protected $descriptor;

    protected function getModel($table){

        return new DB($table);

    }

    public function fill($data){

        $this->descriptor->prepare($data);

        return $this;

    }

    public function save(){

        $data = $this->descriptor->insert();

        return $data;

    }

}