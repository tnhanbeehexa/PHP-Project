
<?php

class ProductModel extends BaseModel{
    const TABLE = 'products';

    public function getAll($select = ['*'],$orderBys = []) {
        return $this->all(self::TABLE, $select,$orderBys);
    }

    // public function findById($id) {
    //     return $this->findOne(self::TABLE, $id = 1);
    // }

    public function getProductsByCategoryId($categoryId) {
        $sql = "SELECT * FROM ". self::TABLE." WHERE category_id = $categoryId";

        // $resutl = $this->__query($sql);
        
        $query = $this->__query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query)) 
        { 
            array_push($data, $row);
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