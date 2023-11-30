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
        $sql = "SELECT * FROM {$table} WHERE {$column} = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);
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
        $query = mysqli_query($this->connect, $sql); // Use the established connection for querying
        if (!$query) {
            die(mysqli_error($this->connect)); // Handle query errors here
        }
        return $query;
    }

    protected function loadUserId() {
        
    }
}