<?php

class CartModel extends BaseModel {
    const TABLE = 'carts';
    const SUB_TABLE = 'cart_items';
    public function getAllCartItemsByCartId($cartId) {
        return $this->findById(self::SUB_TABLE, $cartId, 'cart_id');
    }

    public function checkCartExists($userId) {
        $sql = 'SELECT * FROM ' . self::TABLE .' WHERE user_id ="'.$userId. '"';
      
        $result = $this->__query($sql);

        // Kiểm tra nếu có dòng dữ liệu được trả về
        if ($result && $result->num_rows > 0) {
            return true; // Giỏ hàng tồn tại cho người dùng này
        } else {
            return false; // Giỏ hàng không tồn tại cho người dùng này
        }
    }

    public function checkCartItemExists($cartId) {
        $sql = "SELECT * FROM ". self::SUB_TABLE. " WHERE cart_id = $cartId";
        // die($sql);
        $result = $this->__query($sql);

        if($result && $result->num_rows >0) {
            return true;
        }else {
            return false;
        }
    }

    public function getCartId($user_id) {
        // session_start();
        // die("User id của Card Model: ".$user_id);
        $sql = "SELECT * FROM ". self::TABLE. " WHERE user_id = $user_id";
        $result = $this->__query($sql);

        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // echo '<pre>';
                // print_r($row);
                // $_SESSION['cart_id']  =  $row['cart_id'];
                return $row['cart_id'];
            }
        }
        return 'Không có cart id';
    }
    public function createCart($userId) {
        $sqlResetAutoIncrement = "ALTER TABLE " . self::TABLE . " AUTO_INCREMENT = 1";
        $this->__query($sqlResetAutoIncrement);

        $sql = "SELECT * FROM " . self::TABLE ." WHERE user_id = $userId";
        $result = $this->__query($sql);
        // die($sql);
        if ($result->num_rows > 0) {
            // die('Có user id nha');
            return;
        }else {
            // die('Không user id nha');
            $sql = 'INSERT INTO '. self::TABLE. ' (user_id, status) VALUES ('. $userId .' , 0)';
            $result2 = $this->__query($sql);
    
            return $result2;
        }

       
    }

    public function addItemToCart($cart_id, $product_id, $product_quantity, $product_price, $product_name) {
        
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $existingItemSql = "SELECT quantity FROM " . self::SUB_TABLE . " WHERE cart_id = ? AND product_id = ?";
        $existingItemStmt = $this->connect->prepare($existingItemSql);
        $existingItemStmt->bind_param("ii", $cart_id, $product_id);
        $existingItemStmt->execute();
        $existingItemResult = $existingItemStmt->get_result();
        $existingItem = $existingItemResult->fetch_assoc();
        $existingItemStmt->close();
    
        if ($existingItem) {
            // Nếu sản phẩm đã tồn tại, cập nhật quantity
            $newQuantity = $existingItem['quantity'] + 1;
            $updateSql = "UPDATE " . self::SUB_TABLE . " SET quantity = ? WHERE cart_id = ? AND product_id = ?";
            $updateStmt = $this->connect->prepare($updateSql);
            $updateStmt->bind_param("iii", $newQuantity, $cart_id, $product_id);
            $result = $updateStmt->execute();
            $updateStmt->close();
    
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            $insertSql = "INSERT INTO " . self::SUB_TABLE . " (cart_id, product_id, quantity, price, product_name) VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $this->connect->prepare($insertSql);
            $insertStmt->bind_param("iiids", $cart_id, $product_id, $product_quantity, $product_price, $product_name);
            // die($insertSql);
            $result = $insertStmt->execute();
            $insertStmt->close();
    
            if ($result) {
                return true;
            } else {
                return false;

            }
        }
    }
    

    public function deleteAllItems() {
        session_start();
        $cart_id = $_SESSION['cart_id'];
    
        // Xóa tất cả các dòng từ bảng cart_items
        $sqlDelete = "DELETE FROM " . self::SUB_TABLE . " WHERE cart_id = " . $cart_id;
        $this->__query($sqlDelete);
    
        // Reset auto-increment sequence cho cột cart_item_id
        $sqlResetAutoIncrement = "ALTER TABLE " . self::SUB_TABLE . " AUTO_INCREMENT = 1";
        $this->__query($sqlResetAutoIncrement);
        
        return true;
    }
    public function getTotalPrice() {
        $cart_id = $_SESSION['cart_id'];
        $sql = 'SELECT * FROM ' . self::SUB_TABLE . " WHERE cart_id = {$cart_id}";
        // die($sql);
        $result = $this->__query($sql);

        $totaPrice = 0;

        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $totaPrice += (int)$row['quantity'] * (double)$row['price'];
                // echo "Đây là quantity: {$row['quantity']} đây là price: {$row['price']}";
                // var_dump($totaPrice);
            }
        }
        // die($totaPrice);
        return $totaPrice;
    }

    public function getCartItemQuantity($product_id) {
        // session_start();
        $cart_id = $_SESSION['cart_id'];
        $sql = 'SELECT * FROM ' . self::SUB_TABLE ." WHERE product_id = {$product_id} and cart_id = {$cart_id}";
        // die($sql);
        $result = $this->__query($sql);

        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $quantity = $row['quantity'];
                return $quantity;
            }
        }
    } 

    public function updateCartItemQuantity($product_id, $newQuantity) {
        // session_start();
        $cart_id = $_SESSION['cart_id'];
        $sql = 'UPDATE ' . self::SUB_TABLE ." SET quantity = {$newQuantity} WHERE product_id = {$product_id} and cart_id = {$cart_id}";
        
        $result = $this->__query($sql);

        return $result;
    }
    
    public function deleteCartItemById($product_id) {
        $cart_id = $_SESSION['cart_id'];

        $sql = 'DELETE FROM ' . self::SUB_TABLE ." WHERE product_id = {$product_id} and cart_id = {$cart_id}";

        $result = $this->__query($sql);

        return $result;
    }

    public function isItemExistsInCart($cart_id, $product_id) {
        $existingItemSql = "SELECT quantity FROM " . self::SUB_TABLE . " WHERE cart_id = ? AND product_id = ?";
        $existingItemStmt = $this->connect->prepare($existingItemSql);
        $existingItemStmt->bind_param("ii", $cart_id, $product_id);
        $existingItemStmt->execute();
        $existingItemResult = $existingItemStmt->get_result();
        $existingItem = $existingItemResult->fetch_assoc();
        $existingItemStmt->close();
    
        return ($existingItem !== null);
    }
    
    // Trong CartModel
    public function updateOneCartItemQuantity($product_id, $quantity) {
        session_start();
        $cart_id = $_SESSION['cart_id'];
    
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        if ($this->isItemExistsInCart($cart_id, $product_id)) {
            // Nếu sản phẩm đã tồn tại, cập nhật quantity
            $newQuantity = $this->getExistingItemQuantity($cart_id, $product_id) + $quantity;
            $this->updateCartItemQuantityInDatabase($cart_id, $product_id, $newQuantity);
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            $product = $this->getCartItemById($product_id);
            $this->addNewItemToCart($product, $cart_id);
        }
    }
    // Trong CartModel
    private function getExistingItemQuantity($cart_id, $product_id) {
        $existingItemSql = "SELECT quantity FROM " . self::SUB_TABLE . " WHERE cart_id = ? AND product_id = ?";
        $existingItemStmt = $this->connect->prepare($existingItemSql);
        $existingItemStmt->bind_param("ii", $cart_id, $product_id);
        $existingItemStmt->execute();
        $existingItemResult = $existingItemStmt->get_result();
        $existingItem = $existingItemResult->fetch_assoc();
        $existingItemStmt->close();

        return $existingItem['quantity'];
    }

    // Trong CartModel
    private function updateCartItemQuantityInDatabase($cart_id, $product_id, $newQuantity) {
        $updateSql = "UPDATE " . self::SUB_TABLE . " SET quantity = ? WHERE cart_id = ? AND product_id = ?";
        $updateStmt = $this->connect->prepare($updateSql);
        $updateStmt->bind_param("iii", $newQuantity, $cart_id, $product_id);
        $updateStmt->execute();
        $updateStmt->close();
    }

    // Trong CartModel
    private function addNewItemToCart($product, $cart_id) {
        $insertSql = "INSERT INTO " . self::SUB_TABLE . " (cart_id, product_id, quantity, price, product_name) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $this->connect->prepare($insertSql);
        $insertStmt->bind_param("iiids", $cart_id, $product['product_id'], $product['quantity'], $product['price'], $product['name']);
        $insertStmt->execute();
        $insertStmt->close();
    }
    

    public function deleteOneItem($product_id) {
        session_start();
        $cart_id = $_SESSION['cart_id'];
        $sql = "DELETE FROM " . self::SUB_TABLE . " WHERE product_id = $product_id AND cart_id = $cart_id";
        // die($sql);
        $result = $this->__query($sql);

        return $result;
    }

    public function getCartItemById($product_id) {
        $sql = "SELECT * FROM products WHERE product_id = $product_id ";
        // die($sql);
        $result = $this->__query($sql);
        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // print_r($row);
                return $row;
            }
        } 
    }
}