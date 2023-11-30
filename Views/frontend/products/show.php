<?php
    session_start();
?>
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
    <h1><?php echo $pageTitle;
    ?></h1>
    <div class="row">
        <div class="product__container">
            <form action="?controller=cart&action=updateOneCartItemQuantity" method="POST">
                <div class="product__detail" style="display: flex;">
                    <img style="width: 400px;height: 400px;" src="Public/images/<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>">
                    <div class="product__detail__description" style="display: flex; flex-direction: column;margin-left: 24px;">
                        <h1 class="product__detail__name"><?php echo $product['name']?></h1>
                        <div class="product__detail__price-block" style="display: flex;align-items: flex-start;margin-top: 24px; flex-direction: column;">
                            
                            <div class="product__price__block" style="display: flex">
                                <h2>Giá sản phẩm: </h2>
                                <h3 class="product__detail__price" style="font-size: 30px;margin-left: 24px; display: block"><?php echo $product['price'] ?>đ</h3>
                            </div>
                            <div class="product__detail__quantity" style="display:flex; align-items: center; margin-top: 20px;">
                                <p  class="product-quantity" onclick="changeQuantity('-')">-</p>
                                <input class="product-quantity-input" type="text" name="product_quantity[<?php echo $product['product_id'] ?>]" value="1">
                                <p  class="product-quantity" onclick="changeQuantity('+')">+</p>
                            </div>
                        </div>
                        <button type="submit" class="btn" style="margin-top: auto;">
                            <!-- <a style="text-decoration: none; color: #fff;width: 100%; height:100%;display: inline-block" href="">Thêm vào giỏ hàng</a> -->
                            Thêm vào giỏ hàng
                        </button>
                    </div>

                </div>
            </form>
            
        </div>
    </div>
</div>
<script>
    function changeQuantity(operation) {
        var quantityInput = document.querySelector('.product-quantity-input');
        var currentValue = parseInt(quantityInput.value);

        if (operation == '-') {
            quantityInput.value = currentValue - 1 > 0 ? currentValue - 1 : 1;
        } else if (operation == '+') {
            quantityInput.value = currentValue + 1;
        }
        console.log(quantityInput.value);
    }
</script>

<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
