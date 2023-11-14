<?php
class BaseModel extends Database {
    protected $connect;
    protected $userId;
    public function __construct()
    {
        $this->connect = $this->connect();
    }

    public function all($table, $select = ['*'],$orderBys = []) {
        $columns = implode(',', $select);

        $orderByString = implode(' ', $orderBys);
        if($orderByString) {
            $sql = "SELECT {$columns} FROM {$table} ORDER BY {$orderByString}";
        }else {
            $sql = "SELECT {$columns} FROM {$table} ";
        }
        $query = $this->__query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)) 
        { 
            array_push($data, $row);
        }
        return $data;
    }

    public function findById($table, $id, $column) 
    {
        $sql = "SELECT * FROM {$table} WHERE {$column} = {$id}";

        // die($sql);
        $query = $this->__query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        return $data;
    }   

    public function create($table, $data = [])
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        $keyString = implode(',', array_keys($data)) ;
       
        
        $newValues = array_map(function($value) {
            return "'" . $value . "'";
        }, array_values($data));
        $valueString = implode(',',$newValues);
            
        
        $sql = "INSERT INTO {$table}({$keyString}) VALUES ({$valueString})";
        $this->__query($sql);
    }

    public function update($table, $id, $data = []) 
    {
        echo $table;
        echo $id;
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        $dataSets = [];
        foreach ($data as $key => $value) {
            array_push($dataSets, "{$key} = '" . $value . "'");
        }

        echo '<pre>';
        $dataSets = implode(',',$dataSets);

        $sql = "UPDATE {$table} SET {$dataSets}
            WHERE product_id = {$id}";
        
        $this->__query($sql);
    }

    public function delete($table, $id)
    {
        
        $sql = "DELETE FROM {$table} WHERE product_id = {$id}";
        $this->__query($sql);
    }

    protected function __query($sql) 
    {
        return mysqli_query($this->connect, $sql);
    }

    protected function loadUserId() {
        
    }
}