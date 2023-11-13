<?php
class CategoryModel  extends BaseModel {
    const TABLE = 'categories';
    public function getAllCategories() {
        return $this->all(self::TABLE);
    }

   
}

?>