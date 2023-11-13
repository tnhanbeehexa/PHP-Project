<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Public/style/main.css">
    <link rel="stylesheet" type="text/css" href="Public/style/style.css">
    <link rel="stylesheet" type="text/css" href="Public/style/product.css">
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
            echo "Đây là cart_id: " . $_SESSION['cart_id'] . " của user_id: " . $_SESSION['user_id'] ;
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
                                <a href=\"\">
                                    <button class=\"btn-danger\">Xóa</button>
                                </a>
                            </td>
                        </tr>";
                }
            ?>
                    
                </tbody>
            </table>
            <h2 style="text-align: right">Tổng tiền: <?php echo $totalPrice ?></h2>
            <a style="text-decoration: none;" href="?controller=cart&action=deleteAllItemInCart">
                <button class="btn">Xóa tất cả</button>
            </a>
            <!-- <a href="?controller=cart&action=updateCartItemQuantity">
                <button class="btn">Cập nhật số lượng</button>
            </a> -->
            <button type="submit" class="btn">Cập nhật số lượng</button>
        </form>
        <!-- End else -->
        <?php }?>
    </div>

<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
