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
        
            if(isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $cart_id ='';
                $this->cartModel->createCart($userId);
        
                if(!isset($_SESSION['cart_id'])) {
                    $cart_id = $this->cartModel->getCartId($userId);
                    $_SESSION['cart_id'] = $cart_id ;
                } else {
                    $cart_id = $_SESSION['cart_id'];
                }
        
                if($this->cartModel->checkCartItemExists($cart_id)) {
                    $notification = 'Chào mừng trở lại với cart';
                    $totalPrice = $this->cartModel->getTotalPrice();
        
                    // Lấy ra các cart_item có cart_item_status = 'pending'
                    $data = $this->cartModel->getPendingCartItems($cart_id);
                } else {
                    $notification = 'Giỏ hàng rỗng!';
                }
            } else {
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
            
            $cart_item_status = 'pending';

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

            if($this->cartModel->addItemToCart($cart_id, $productId, $productQuantity, $productPrice,  $productName, $cart_item_status)) {
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

        public function pay() {
            session_start();
            $user_id = $_SESSION['user_id'];
            $cart_id = $_SESSION['cart_id'];
            $user_address = $this->cartModel->getUserAddress($user_id);
            $totalPrice = $this->cartModel->getTotalPrice();
            $payment_date = date("Y-m-d H:i:s");
            
            $payment_status = "pending approval";
            $cart_item_status = "pending approval"; // Trạng thái mới
        
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $payment_method = $_POST['payment_method'];
                $payment_id = $this->cartModel->addPayment($user_id, $cart_id, $totalPrice, $payment_status, $payment_date, $payment_method);
                
                // Chuyển trạng thái của cart_item thành 'pending approval'
                $this->cartModel->updateCartItemStatus($cart_id, $cart_item_status, $payment_id);
        
                // $this->cartModel->deleteAllItems();
                header('Location: ?controller=cart&action=index');
            }
        
            return $this->view('frontend.carts.payment', [
                'user_address' => $user_address,
                'totalPrice' => $totalPrice,
            ]);
        }
        
    }
?>