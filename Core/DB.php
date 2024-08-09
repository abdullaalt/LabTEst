<?php

namespace Core;

class DB{

    private $table;
    private $pdo;
    private $stmt;

    private $wheres = [];
    private $data;
    private string $query;

    public function __construct($table){

        $this->table = $table;

        $this->pdo = new \PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);

    }

    protected function getRecords(){

        $this->query = 'SELECT * FROM ' . $this->table;
        
        return $this;

    }

    public function get(){

        $this->query = 'SELECT * FROM ' . $this->table;

        $this->prepareWhere();
        
        $this->stmt->execute();

        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function update(){

        $keys = array_keys($this->data);

        $this->query = 'UPDATE ' . $this->table . ' SET ';

        foreach($keys as $key){
            $this->query .= $key . ' = :' . $key . ', ';
        }

        $this->query = rtrim($this->query, ', ');

        $this->prepareWhere();

        foreach($this->data as $key => $value){
            $this->stmt->bindParam(':'.$key, $this->data[$key]);
        }

        $this->stmt->execute();

        $data = $this->stmt->fetch(\PDO::FETCH_ASSOC);

        return $data; 

    }

    public function prepareWhere(){

        if (count($this->wheres) > 0) {

            $this->query .= ' WHERE ';
            foreach ($this->wheres as $where) {
                $this->query .= $where[0] . $where[1] . ':' . $where[0] . ' AND ';
            }

            $this->query = rtrim($this->query, ' AND ');

        }

        $this->query .= ' ORDER BY id DESC';

        $this->stmt = $this->pdo->prepare($this->query);

        if (count($this->wheres) > 0) {

            foreach ($this->wheres as $where) {
                $this->stmt->bindParam(':' . $where[0], $where[2]);
            }

        }

    }

    public function prepare($data){

        $this->data = $data;

        return $this;
        
    }

    public function insert(){

        $keys = array_keys($this->data);

        $this->query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $keys) . ') VALUES (:' . implode(',:', $keys) . ')';

        $this->stmt = $this->pdo->prepare($this->query);

        foreach($this->data as $key => $value){
            $this->stmt->bindParam(':'.$key, $this->data[$key]);
        }

        $this->stmt->execute();

        $last_id = $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare("SELECT * FROM ". $this->table ." WHERE id = :id");
        $stmt->bindParam(':id', $last_id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function where($key, $value, $operator = '='){
        $this->wheres[] = [$key, $value, $operator];
        return $this;
    }

    public function first(){

        $this->query = 'SELECT * FROM ' . $this->table;

        $this->prepareWhere();
        
        $this->stmt->execute();

        return $this->stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function delete(){

        $this->query = 'DELETE FROM ' . $this->table;

        $this->prepareWhere();

        $this->stmt->execute();
    }

}