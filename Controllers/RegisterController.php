<?php
    class RegisterController extends BaseController {
        private $registerModel;

        public function __construct() {
            $this->loadModel('RegisterModel');
            $this->registerModel = new RegisterModel();
        }

        public function index() {
            $title = 'Chào mừng tới đăng kí';
            return $this->view('frontend.register.register', [
                'title' => $title,
            ]);
        }
        
        public function register() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_name = $_POST['user_name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $notification = 'Gmail hoặc tên đăng nhập đã có người đăng kí!!';

                if (!$this->registerModel->checkUserExists($user_name, $email)) {
                    // Nếu người dùng chưa tồn tại, thêm mới
                    $this->registerModel->addUser($user_name, $email, $password);
                    
                    // Chuyển hướng hoặc thực hiện các hành động khác sau khi đăng kí thành công
                    // Ví dụ: Chuyển hướng đến trang đăng nhập sau khi đăng kí thành công
                    header('Location: ?controller=login&action=index');
                    
                } else {
                    // Xử lý thông báo hoặc hành động nếu người dùng đã tồn tại
                    // Ví dụ: Hiển thị thông báo lỗi người dùng đã tồn tại
                    return $this->view('frontend.register.register', [
                        'notification' => $notification,
                    ]);
                }
            }
        }
    }
?>