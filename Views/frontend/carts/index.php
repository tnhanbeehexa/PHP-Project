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
?>
    <div class="container">
        <?php if(isset($notification_warning)) {
            echo "<h1 class=\"alert-warning\">$notification_warning</h1>";
        }else {
        ?>
        <h1><?php echo $notification?></h1>
        <h1><?php 
            // echo "Đây là cart_id: " . $_SESSION['cart_id'] . " của user_id: " . $_SESSION['user_id'] ;
        ?></h1>
        <form action="?controller=cart&action=updateCartItemQuantity" method="POST">

            <table>
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá thành</th>
                        <th>Lựa chọn</th>
                    </tr>
                </thead>
                <tbody>
            <?php 
                foreach($data as $val) {
                    // echo '<pre>';
                    // // print_r($val['product_id']);
                    // echo $val['product_id'];
                    echo "<tr>
                            <td>{$val['product_id']}</td>
                            <td>{$val['product_name']}</td>
                            <td class=\"form-update-quantity\">
                                <a class = \"product-quantity\" href=\"?controller=cart&action=decreaseProductQuantity&product_id={$val['product_id']}\">-</a>
                                <input class=\"product-quantity-input\" type=\"text\" name=\"product_quantity[{$val['product_id']}]\" value = \"{$val['quantity']}\" />
                                <a class = \"product-quantity\" href=\"?controller=cart&action=increaseProductQuantity&product_id={$val['product_id']}\">+</a>
                            </td>
                            <td>{$val['price']}</td>
                            <td>
                                <a style=\"cursor: pointer;
                                padding: 8px 12px;
                                text-decoration: none;
                                color: #fff;
                                background-color: brown;
                                font-size: 22px;
                                border-radius: 4px;
                                \" href=\"?controller=cart&action=deleteOneItemInCart&product_id={$val['product_id']}\">
                                    XÓA
                                </a>
                            </td>
                        </tr>";
                        
                }
            ?>
                    
                </tbody>
            </table>
            <h2 style="text-align: right;margin-bottom: 100px;">Tổng tiền: <?php echo $totalPrice ?></h2>
            <a class="btn" style="text-decoration: none;" href="?controller=cart&action=deleteAllItemInCart">
                Xóa tất cả
            </a>
            <!-- <a href="?controller=cart&action=updateCartItemQuantity">
                <button class="btn">Cập nhật số lượng</button>
            </a> -->
            <button type="submit" class="btn">Cập nhật số lượng</button>
            <a style="text-decoration: none; float:right" href="?controller=cart&action=pay" class="btn">Thanh Toán</a>
        </form>
        <!-- End else -->
        <?php }?>
    </div>

<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
