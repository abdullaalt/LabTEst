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

    public function where($column, $operator, $value){
        $this->descriptor->where($column, $operator, $value);
        return $this;
    }

    public function first(){
        return $this->descriptor->first();
    }

    public function delete(){
        return $this->descriptor->delete();
    }

    public function get(){
        return $this->descriptor->get();
    }

}