<?php

namespace Models;

use Models\Models;

class Users extends Models{

    private $table = 'users';

    public function __construct(){

        $this->descriptor = $this->getModel($this->table);

    }

    public function getUsers(){

        return $this->descriptor->getRecords();

    }

}