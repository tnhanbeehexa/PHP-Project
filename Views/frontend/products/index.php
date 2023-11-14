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
        <div class="categories__container">
            <ul class="categories__list">
                <li>Danh mục sản phẩm</li>
                
                <?php 
                    foreach($categories as $category) {
                        echo "<li><a class=\"categories__link\" href=\"?controller=product&action=index&categoryId={$category['category_id']}\">".$category['category_name']."</a></li>";
                        // echo $category['category_name'];
                    }
                ?>
            </ul>
        </div>
        <div class="product__container">
            <?php
                // if(isset($_SESSION['user_id'])) {
                //     echo "Đây là session user_id: " . $_SESSION['user_id'];
                // }else {
                //     echo 'Chưa có session user_id';
                // }
                // echo '<pre>';
                // print_r($products);
                // echo '</pre>';
                foreach($products as $key => $product) {
                    $productHtml = '<div class="card col-4" style="margin-bottom: 24px">
                                        <a href="?controller=product&action=showDetailProduct&product_id='.$product['product_id'].'">
                                            <img src="'. $product['image'] .'" class="card-img-top" alt="'.$product['name'] .'">
                                        </a>
                                        <div class="card-body">
                                            <h2 class="card-title">'. $product['name'] .'</h2>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>
                                            <a href="?controller=cart&action=addCartItem&product_id=' .$product['product_id'].'&product_name=' . $product['name'].'&product_price='.$product['price'].'&product_quantity='. $product['quantity'].'" class="btn btn-primary btn-buy">Buy</a>
                                        </div>
                                        <div class="card-footer">
                                            <p class="product-price">đ '. $product['price'] .'</p>
                                        </div>
                                    </div>';
                    $decodedProductHtml = html_entity_decode($productHtml);

                    echo $decodedProductHtml;
                }
            ?>
        </div>
    </div>
</div>


<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
