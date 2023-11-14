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
            $totalPrice = 0;
            $data = [];
            $notification = '';
            //Lấy tổng tiền
            
            // die($totalPrice);

            if(isset($_SESSION['user_id'])) {
                // die('Xin chào');
                $userId = $_SESSION['user_id'];
                $cart_id ='';
                if(isset($_SESSION['cart_id'])) {
                    $cart_id = $_SESSION['cart_id'];
                }
                // die($userId);
                // $this->cartModel->checkCartItemExists($userId);
                if($this->cartModel->checkCartItemExists($cart_id)) {
                    $notification = 'Chào mừng trở lại với cart';

                    // $cartId = $this->cartModel->getCartId($userId);
                    // $_SESSION['cart_id']  =  $cartId ;
                    $totalPrice = $this->cartModel->getTotalPrice();

                    $data = $this->cartModel->getAllCartItemsByCartId($cart_id);
                }else {
                    $this->cartModel->createCart($userId);
                    $cartId = $this->cartModel->getCartId($userId);
                    // die($cartId);
                    $_SESSION['cart_id']  =  $cartId ;
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
            session_start();
            // echo 1;
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // echo $_POST['product_quantity'];

                if(isset($_POST['product_quantity']) && is_array($_POST['product_quantity'])) {
                    // echo '<prev>';
                    // print_r($_POST['product_quantity']);
                    // echo '</prev>';
                    // echo count($_POST['product_quantity']);

                    foreach ($_POST['product_quantity'] as $product_id => $new_quantity) {
                        // Ensure $product_id and $new_quantity are valid values
                        // echo "ProductId: {$product_id} new quantity = {$new_quantity}\n";
                        $product_id = intval($product_id);
                        $new_quantity = intval($new_quantity);

                        if($new_quantity <=0) {
                            $this->cartModel->deleteCartItemById($product_id);
                        }else {
                            $this->cartModel->updateCartItemQuantity($product_id, $new_quantity);
                        }
                        // die( $product_id . ' ' . $new_quantity);
                        // Update the quantity for the product in the cart
                        // $this->cartModel->updateCartItemQuantity($product_id, $new_quantity);
                    }
                    
                }
            }
            header('Location: ?controller=cart&action=index');

        }

        public function updateOneCartItemQuantity() {
            // session_start();
            if(isset($_SESSION['cart_id'])) {
                $cart_id = $_SESSION['cart_id'];
            }
            $product_quantity = $_POST['product_quantity'];
            foreach ($product_quantity as $product_id => $quantity) {
                $this->cartModel->updateOneCartItemQuantity($product_id, $quantity);
            }
            // $this->cartModel->updateOneCartItemQuantity()
            header('Location: ?controller=cart&action=index');

        }

        public function deleteOneItemInCart() {
            if(isset($_GET['product_id'])) {
                $product_id = $_GET['product_id'];
                $this->cartModel->deleteOneItem($product_id);
                header('Location: ?controller=cart&action=index');
            }
        }
    }
?>