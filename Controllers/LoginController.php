<?php

class LoginController extends BaseController 
{   
    private $loginModel;
    public function __construct()
    {
        $this->loadModel('LoginModel');
        $this->loginModel = new LoginModel();
    }
    public function index() {
        $title = "Chào mừng bạn đến với đăng nhập";
        return $this->view('frontend.users.login', [
            'title' => $title,
        ]);
    }

    public function login() {
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        // die($user_name .' '. $password);

        if($this->loginModel->checkUserExists($user_name, $password)) {
            $user_id = $this->loginModel->getUserId($user_name, $password);
            // die($user_id);
            $this->setSession('user_id', $user_id);
            $this->setSession('user', $user_name);
            // die($_SESSION['user_id']);
            header('Location: ?controller=product&action=index');
            // $pageTitle = 'Xin chào tôi mới từ đăng nhập qua';
            // return $this->view('frontend.products.index', [
            //     'pageTitle' => $pageTitle
            // ]);
            return;
        }else {
            header('Location: ?controller=login&action=index');
            
        }
    }

    public function logout() {
        session_start();
        // Xóa tất cả các biến session
        $_SESSION = array();
        session_destroy();
        header('Location: ?controller=login&action=index');
    }

    public function register() {
        $title = 'Chào mừng tới đăng kí';
        die(123);
        $this->view('frontend.users.register', [
            'title' => $title,
        ]);

        
    }
}

?>