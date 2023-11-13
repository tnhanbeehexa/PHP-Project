<?php
    class CartController extends BaseController{
        private $cartModel;
        public function __construct()
        {
            $this->loadModel('CartModel');
            $this->cartModel = new CartModel();
        }
        public function index() {
            session_start();
            $title = "Đây là title của CartController";
            $data = [];
            $notification = '';
            //Lấy tổng tiền
            $totalPrice = $this->cartModel->getTotalPrice();
            // die($totalPrice);

            if(isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $cartId = $this->cartModel->getCartId($userId);
                $_SESSION['cart_id']  =  $cartId ;

                if($this->cartModel->checkCartItemExists($userId)) {
                    $notification = 'Chào mừng trở lại với cart';
                    $data = $this->cartModel->getAllCartItemsByCartId($userId);
                }else {
                    $this->cartModel->createCart($userId);
                 
                    $notification = 'Giỏ hàng rỗng!';
                }
            }else {
                $notification = 'Bạn cần đăng nhập để thực hiện việc này!!';
                return $this->view('frontend.carts.index', [
                    'notification_warning' => $notification,
                ]);
            }
            return $this->view('frontend.carts.index', [
                'totalPrice' => $totalPrice,
                'notification' => $notification,
                'title' => $title,
                'data' => $data,
            ]);
        }


        public function addCartItem() {
            session_start();
            $productName = $_GET['product_name'];
            // die($productName);
            $productPrice = $_GET['product_price'];
            // die($productPrice);

            $productId = $_GET['product_id'];
            $productQuantity = $_GET['product_quantity'];
            

            // Kiểm tra xem user đã đăng nhập hay chưa
            if (!isset($_SESSION['user_id'])) {
                $notification = 'Bạn cần đăng nhập để thực hiện việc này!!';
                return $this->view('frontend.carts.index', [
                    'notification_warning' => $notification,
                ]);
                // exit();
            }else {
                $user_id = $_SESSION['user_id'];
            }
            $cart_id = $this->cartModel->getCartId($user_id);

            if($this->cartModel->addItemToCart($cart_id, $productId, $productQuantity, $productPrice,  $productName)) {
                header('Location: ?controller=cart&action=index');
            }
        }

        public function store() {
            echo __METHOD__;
        }

        public function deleteAllItemInCart() {
            // echo __METHOD__;
            // session_start();
            // $userId = $_SESSION['user_id'];

            // if(!isset($user_id)) {

            // }
            if($this->cartModel->deleteAllItems()) {
                header('Location: ?controller=cart&action=index');
            }
        }

        public function decreaseProductQuantity() {
            session_start();

            if(isset($_GET['product_id'])) {
                $product_id = $_GET['product_id'];
                // Lấy được quantity của product
                $quantity = $this->cartModel->getCartItemQuantity($product_id);
                $quantity = $quantity - 1;
                
                if($quantity <= 0) {
                    $this->cartModel->deleteCartItemById($product_id);

                }

                // echo $this->cartModel->getCartItemQuantity($product_id);
                $this->cartModel->updateCartItemQuantity($product_id, $quantity);
                header('Location: ?controller=cart&action=index');
            }
        }

        public function increaseProductQuantity() {
            session_start();

            if(isset($_GET['product_id'])) {
                $product_id = $_GET['product_id'];
                // Lấy được quantity của product
                $quantity = $this->cartModel->getCartItemQuantity($product_id);
                $quantity = $quantity + 1;
                // echo $this->cartModel->getCartItemQuantity($product_id);
                $this->cartModel->updateCartItemQuantity($product_id, $quantity);
                header('Location: ?controller=cart&action=index');
            }
        }

        public function updateCartItemQuantity() {
            echo 1;
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo $_POST['product_quantity'];

                if(isset($_POST['product_quantity']) && is_array($_POST['product_quantity'])) {
                    echo __METHOD__;

                    foreach ($_POST['product_quantity'] as $product_id => $new_quantity) {
                        // Ensure $product_id and $new_quantity are valid values
                        $product_id = intval($product_id);
                        $new_quantity = intval($new_quantity);
                        die( $product_id . ' ' . $new_quantity);
                        // Update the quantity for the product in the cart
                        // $this->cartModel->updateCartItemQuantity($product_id, $new_quantity);
                    }
                    
                }
            }
        }
    }
?>