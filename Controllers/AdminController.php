<?php
class AdminController extends BaseController {
    private $adminModel;
    public function __construct() {
        $this->loadModel('AdminModel');
        $this->adminModel = new AdminModel();
    }
    public function index($successMessage = '') {
        // echo __METHOD__;
        $data = $this->adminModel->getAllProducts();
        $pageTitle = 'Trang danh sách sản phẩm';
        return $this->view('admin.products.index', [
            'pageTitle' => $pageTitle,
            'data' => $data,            
            'successMessage' => $successMessage

        ]);
    }

    public function addProduct() {
        $successMessage = 'Thêm sản phẩm thành công';

        // echo __METHOD__;
        $categories = $this->adminModel->getAllCategoryNames();
       
        $success = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy thông tin từ form
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
        
            // Thông tin về tệp ảnh
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
        
            // Thư mục trong dự án để lưu ảnh
            $uploads_dir = 'Public/images';
        
            // Di chuyển tệp ảnh tải lên vào thư mục lưu trữ
            move_uploaded_file($file_tmp, "$uploads_dir/$file_name");
        
            if($this->adminModel->addProduct($name, $price, $file_name, $category_id)) {
                $success = true;
            }
            // echo "Product information saved successfully!";
            if ($success) {
                // die('true');
                $this->index($successMessage);
                exit();
                // header('Location: ?controller=admin&action=index');
                // exit(); // Chắc chắn dừng việc thực thi sau khi thực hiện redirect
            }
        }
        $this->view('admin.products.add', [
            'categories' => $categories,
            'successMessage' => $successMessage
        ]);
        
    }

    public function updateProduct() {
        $successMessage = 'Update sản phẩm thành công';
        $product_id = $_GET['product_id'];
        $product = $this->adminModel->getProductById($product_id);
        $categories = $this->adminModel->getAllCategoryNames();
        $pageTitle = 'Update sản phẩm';
        $success = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy thông tin từ form
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            
            // Thông tin về tệp ảnh (nếu cần)
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            
            // Thư mục trong dự án để lưu ảnh (nếu cần)
            $uploads_dir = 'Public/images';
            
            // Di chuyển tệp ảnh tải lên vào thư mục lưu trữ (nếu cần)
            move_uploaded_file($file_tmp, "$uploads_dir/$file_name");
            
            // Gọi hàm để cập nhật sản phẩm
            if($this->adminModel->updateProduct($product_id, $name, $price, $category_id, $file_name)) {
                $success = true;
                
            }
            if ($success) {
                $this->index($successMessage);
                exit();
    
                // header('Location: ?controller=admin&action=index');
                // exit(); // Chắc chắn dừng việc thực thi sau khi thực hiện redirect
            }
            
            // Chuyển hướng sau khi cập nhật xong
            // exit(); // Dừng việc thực thi sau khi thực hiện redirect
        }
       
        return $this->view('admin.products.update', [
            'product' => $product,
            'pageTitle' => $pageTitle,
            'successMessage' => $successMessage,
            'categories' => $categories,
        ]);
    }
    
    public function deleteProduct() {
        $successMessage = 'Xóa sản phẩm thành công';
        $product_id = $_GET['product_id'];

        if($this->adminModel->deleteProduct($product_id)) {
            $this->index($successMessage);
            // header('Location: ?controller=admin&action=index');
        }
    }
    
    public function updatePaymentStatus() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $paymentId = $_POST['payment_id'];
            $newPaymentStatus = $_POST['payment_status'];
    
            // Gọi hàm trong AdminModel để cập nhật payment_status
            $success = $this->adminModel->updatePaymentStatus($paymentId, $newPaymentStatus);
    
            // if ($success) {
            //     // Redirect hoặc hiển thị thông báo thành công
            //     // Ví dụ: 
            //     header('Location: ?controller=admin&action=index');
            //     exit();
            // } else {
            //     // Xử lý khi cập nhật thất bại
            // }
        }
        $pageTitle = 'Danh sách các order';
        $orders = $this->adminModel->getAllPayments();
        $this->view('admin.orders.update', [
            'orders' => $orders,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_name = $_POST['user_name'];
            $password = $_POST['password'];
            // die($user_name);
            if ($this->adminModel->checkAdminUser($user_name, $password)) {
                // Đăng nhập thành công
               $admin_userName = $this->adminModel->checkAdminUser($user_name, $password);
            //    die($admin_userName);
               $this->setSession('admin_logged_in', $admin_userName);
                $_SESSION['admin_logged_in'] = $admin_userName; // Lưu trạng thái đăng nhập
                $this->index(); // Chuyển hướng đến trang dashboard của admin
                exit();
            } else {
                $errorMessage = 'Đăng nhập không thành công. Vui lòng kiểm tra tên đăng nhập và mật khẩu.';
                // die($errorMessage);
                return $this->view('admin.login.index', ['errorMessage' => $errorMessage]);
            }
        } else {
            // Nếu không phải là phương thức POST, hiển thị form đăng nhập
            return $this->view('admin.login.index');
        }

        return $this->view('admin.login.index');
    }
}

?>