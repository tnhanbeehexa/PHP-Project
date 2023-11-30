<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Public/style/main.css">
    <link rel="stylesheet" type="text/css" href="Public/style/style.css">
    <link rel="stylesheet" type="text/css" href="Public/style/product.css">
    <script src="Public/js/main.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
</head>
<body>
<?php 
    
    require __DIR__ . '/../partials/header.php' ;
?>
    <div class="container">
        <form action="?controller=cart&action=pay" method="POST">
            <div class="sub_header" style="margin-top: 24px;
                                        padding: 10px 16px;
                                        border-radius: 6px;
                                        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
                <h1 style="color: #ee4d2d;">
                    <i style="margin-right:auto;" class="fa-solid fa-location-dot"></i>Địa chỉ nhận hàng
                </h1>
                <p style="font-size: 18px;margin-left: 2px;margin-top: 12px;"><?php echo $user_address;?></p>
            </div>
    
            <div style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
                        border-radius: 6px;
                        margin: 24px 0;
                        padding: 10px 16px;" class="payment__container">
                <h1 style="color: #ee4d2d;" class="payment__method__header">Chọn phương thức thanh toán</h1>
                <div style="margin-top: 24px;" class="payment__method">
                    <label style="font-size: 20px; margin-right: 12px;" for="payment_method">Chọn phương thức thanh toán:</label>
                    <select style="padding: 8px 16px;font-size: 16px;" id="payment_method" name="payment_method">
                        <option value="cash">Trả bằng tiền mặt</option>
                        <option value="credit_card">Trả bằng thẻ tín dụng</option>
                        <!-- Thêm các phương thức thanh toán khác nếu cần -->
                    </select>
                </div>
    
            </div>
    
            <div style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
                        border-radius: 6px;
                        padding: 10px 16px;
                        display: flex;
                        flex-direction: column;
                        align-items: flex-end;" 
                        class="payment__footer">
                <div style="display: flex;
                        flex-direction: column;
                        align-items: flex-end;" class="payment__price">
                    <h1 style="color: #ee4d2d;">Tổng số tiền</h1>
                    <p style="font-size: 24px;"><?php echo $totalPrice;?>đ</p>
                </div>
                <button style="background-color: #ee4d2d;
                            padding: 8px 12px;
                            border: none;
                            color: #fff;
                            font-size: 20px;
                            border-radius: 4px;
                            margin-top: 24px;">
                            Mua hàng
                </button>
            </div>
        </form>
           
    </div>

<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
