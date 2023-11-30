
<?php

class ProductModel extends BaseModel{
    const TABLE = 'products';

    public function getAll($numPage) {
        $numPage = 6 * $numPage;
        // var_dump($numPage);
        $sql = "SELECT *FROM ". self::TABLE ." ORDER BY product_id LIMIT $numPage, 6;";
        $data = [];
        // die($sql);
        $result = $this->__query($sql);
        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getQuantityOfNumpage() {
        $sql = "SELECT *FROM ". self::TABLE;
        // die($sql);
        $result = $this->__query($sql);

        if($result && $result->num_rows > 0) {
            return $result->num_rows;
        }
    }

    // public function findById($id) {
    //     return $this->findOne(self::TABLE, $id = 1);
    // }

    public function getProductsByCategoryId($categoryId, $numPage) {
        $numPage = 6 * $numPage;
        // $sql = "SELECT * FROM ". self::TABLE." WHERE category_id = $categoryId";
        $sql = "select * from ". self::TABLE ." where category_id = $categoryId ORDER BY product_id LIMIT $numPage, 6;";
        // die($sql);
        // $resutl = $this->__query($sql);
        
        $query = $this->__query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)) 
        { 
            array_push($data, $row);
        }
        return $data;
    }

    public function getProductById($product_id) {
        $sql = "SELECT * FROM ". self::TABLE." WHERE product_id = $product_id";
        $result = $this->__query($sql);

        if($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // print_r($row);
                return $row;
            }
        }
    }
    
    public function search($keyword) {
        
    
        $sql = "SELECT p.* 
                FROM " . self::TABLE . " p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.name LIKE '%$keyword%' OR c.category_name LIKE '%$keyword%'";
        // die($sql);
        $result = $this->__query($sql);
    
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
    
        return $data;
    }
    
    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }

    public function updateData($id, $data)
    {
        $this->update(self::TABLE, $id, $data);
    }

    public function destroy($id) {
        $this->delete(self::TABLE,$id);
    }
}