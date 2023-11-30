<?php
class AdminModel extends BaseModel {
   
    public function getCartItemPendingApproval() {
        $sql = 'SELECT * FROM cart_items WHERE cart_item_status = \'pending approval\'';
//         SELECT p.* FROM `products` as p
// JOIN cart_items as ci on ci.product_id = p.product_id
        // die($sql);
        $result =$this->__query($sql);
        $data = [];
        if($result && $result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
                $data[] = $row;
           } 
        }
        // die("xin chào");
        return $data;
    }

    public function getAllProducts() {
        $sql = 'SELECT * FROM products p join categories as c on p.category_id = c.category_id order by product_id ASC';
        // die($sql);
        $result = $this->__query($sql);
     
        $data = [];
        if($result && $result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
                $data[] = $row;
           } 
        }
        return $data;
    }

    public function getAllCategoryNames() {
        $sql = 'SELECT * FROM categories';
        $result = $this->__query($sql);
        
        $data = [];
        if($result && $result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
                $data[] = $row;
           } 
        }
        return $data;
    }

    public function addProduct($name, $price, $file_name, $category_id) {
        // Chuẩn bị câu lệnh SQL
        $resetAutoIncrementSQL = "ALTER TABLE products AUTO_INCREMENT = 1";
        $resetStmt = $this->connect->prepare($resetAutoIncrementSQL);
        $resetStmt->execute();
        $resetStmt->close();
    
        $sql = "INSERT INTO products (name, price, image, category_id, quantity) VALUES (?, ?, ?, ?, ?)";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->connect->prepare($sql);
        
        // Giá trị cố định cho quantity (1 trong trường hợp này)
        $quantity = 1;
        
        // Bind các giá trị vào câu lệnh SQL
        $stmt->bind_param("sdsii", $name, $price, $file_name, $category_id, $quantity);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Đóng kết nối
        $stmt->close();
        return true;
    }
    
    public function getProductById($product_id) {
        $sql = 'SELECT * FROM products WHERE product_id = ' . $product_id;
        // die($sql);

        $result = $this->__query($sql);
        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }
    public function updateProduct($product_id, $name, $price, $category_id, $image) {
        $sql = "UPDATE products SET name = ?, price = ?, image = ?, category_id = ? WHERE product_id = ?";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->connect->prepare($sql);
        
        // Bind các giá trị vào câu lệnh SQL
        $stmt->bind_param("sdsii", $name, $price, $image, $category_id, $product_id);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Đóng kết nối
        $stmt->close();
        return true;
    }

    public function deleteProduct($product_id) {
        $sql = "DELETE FROM products WHERE product_id = ?";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->connect->prepare($sql);
        
        // Bind giá trị product_id vào câu lệnh SQL
        $stmt->bind_param("i", $product_id);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Đóng kết nối
        $stmt->close();

        return true;
    }
    
    public function getAllPayments() {
        $sql = 'SELECT * FROM payment ORDER BY payment_id DESC';
        $result = $this->__query($sql);
    
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function updatePaymentStatus($paymentId, $newPaymentStatus) {
        // Chuẩn bị câu lệnh SQL để cập nhật payment_status
        $updatePaymentSQL = "UPDATE payment SET payment_status = ? WHERE payment_id = ?";
        $updateCartItemSQL = "UPDATE cart_items SET cart_item_status = ? WHERE payment_id = ?";
        
        // Chuẩn bị statement và bind giá trị cho cả hai câu lệnh SQL
        $stmtPayment = $this->connect->prepare($updatePaymentSQL);
        $stmtPayment->bind_param("si", $newPaymentStatus, $paymentId);
        
        $stmtCartItem = $this->connect->prepare($updateCartItemSQL);
        $stmtCartItem->bind_param("si", $newPaymentStatus, $paymentId);
        
        // Thực thi câu lệnh SQL cho cả hai bảng
        $successPayment = $stmtPayment->execute();
        $successCartItem = $stmtCartItem->execute();
        
        // Đóng kết nối và trả về kết quả
        $stmtPayment->close();
        $stmtCartItem->close();
        
        return $successPayment && $successCartItem;
    }

    public function checkAdminUser($user_name, $password) {
        // // Tạo truy vấn SQL để kiểm tra thông tin đăng nhập
        // $sql = "SELECT * FROM admin WHERE user_name = ? LIMIT 1";
        // // Chuẩn bị và thực thi truy vấn SQL
        // $stmt = $this->connect->prepare($sql);
        // $stmt->bind_param("s", $user_name);
        // var_dump($stmt);
        // $stmt->execute();

        // // Lấy kết quả của truy vấn
        // $result = $stmt->get_result();
        // $user = $result->fetch_assoc();

        // // Kiểm tra xem user có tồn tại và mật khẩu khớp không
        // if ($user && password_verify($password, $user['password'])) {
        //     return $user['user_name']; // Đăng nhập thành công
        // } else {
        //     return false; // Đăng nhập không thành công
        // }
        $sql = 'SELECT * FROM admin WHERE user_name = \'' . $user_name .'\' AND password = \'' . $password .'\'';
        // die($sql);
        $result = $this->__query($sql);
        if($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['user_name'];
            }
        }
        return false;
    }
}

?>