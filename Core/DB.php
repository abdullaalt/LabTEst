<?php

namespace Core;

class DB{

    private $table;
    private $pdo;
    private $stmt;

    private string $query;

    public function __construct($table){

        $this->table = $table;

        $this->pdo = new \PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);

    }

    protected function getRecords(){

        $this->query = 'SELECT * FROM ' . $this->table;
        
        return $this;

    }

    protected function get(){

        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function prepare($data){

        $keys = array_keys($data);

        $this->query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $keys) . ') VALUES (:' . implode(',:', $keys) . ')';
die($this->query);
        $this->stmt = $this->pdo->prepare($this->query);

        foreach($data as $key => $value){
            $this->stmt->bindParam(':'.$key, $data[$key]);
        }

        return $this;
        
    }

    public function insert(){

        $this->stmt->execute();

        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}