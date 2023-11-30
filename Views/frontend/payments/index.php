<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Public/style/main.css">
    <link rel="stylesheet" type="text/css" href="Public/style/style.css">
    <link rel="stylesheet" type="text/css" href="Public/style/product.css">
    <script src="Public/js/main.js"></script>
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
</head>
<body>
<?php 

    require __DIR__ . '/../partials/header.php' ;
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>

<div class="container">
    <div class="payment__header">
        <ul>
            <li><a class="cart_item_status" href="?controller=payment&action=showCartItemAwaitingConfirmation">Đơn hàng đang chờ xác nhận</a></li>
            <li><a class="cart_item_status" href="?controller=payment&action=showCartItemWaitingDelivery">Đơn hàng đang chờ vận chuyển</a></li>
            <li><a class="cart_item_status " href="?controller=payment&action=showCartItemSuccessfullyPurchased">Đơn hàng đã mua</a></li>    
        </ul>
    </div>

    <div class="payment__body">
        <?php
            foreach($data as $key => $payment) {
                echo '<div style="margin-top: 24px;
                                display: flex;
                                align-items: flex-start;
                                /* padding: 8px 12px; */
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                min-height: 60px;" 
                                class="cart_items_in_payment__container">
                        <h2 style="display: inline-block;
                                   
                                    /* height: 100%; */
                                    
                                    margin-right: 24px;
                                    padding: 8px 12px;
                                    width: 190px;">'. $payment['product_name'].'</h2>
                        <div style="padding: 8px 12px;
                                    display: flex;
                                    flex-direction: column;
                                    align-items: flex-start;
                                    flex: 1;
                                    font-size: 20px;
                                    border-left: 1px solid;" class="cart_items_in_payment_body">
                            <div style="display: flex;width: 100%;justify-content: space-between;" class="cart_items_in_payment_body__top">';
                            if ($payment['payment_status'] === 'pending approval') {
                                echo '<p>Trạng thái: Đang chờ xác nhận</p>';
                            } elseif ($payment['payment_status'] === 'delivery') {
                                echo '<p>Trạng thái: Đang chờ giao hàng</p>';
                            } elseif ($payment['payment_status'] === 'successful delivery') {
                                echo '<p>Trạng thái: Giao hàng thành công</p>';
                            } else {
                                // Trạng thái không xác định
                                echo '<p>Trạng thái: Không xác định</p>';
                            }
                            echo '<p>Payment id: '. $payment['payment_id'].'</p>
                            </div>
                            <p style="margin-top: 24px;">Phương thức thành toán: '. $payment['payment_method'].'</p>
                            <div style="display: flex;
                                    /* align-items: flex-start; */
                                    justify-content: space-between;
                                    flex: 1;
                                    width: 100%;
                                    margin-top: 23px;" class="cart_items_in_payment_body__bottom">
                                <p>Số lượng: '. $payment['quantity'] .'</p>
                                <p>Thành tiền: '. $payment['quantity'] * $payment['price'].'</p>

                            </div>
                        </div>
                    </div>';
            }
        ?>
    </div>
</div>


<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
