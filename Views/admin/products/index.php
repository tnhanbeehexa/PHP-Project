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

    require  'Views/frontend/partials/header_admin.php' ;
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>

<div style="margin-top: 24px;" class="container">
    <a style="margin-top: 24px" class="btn" href="?controller=admin&action=addProduct">Thêm sản phẩm</a>
    <?php
       if(!empty($successMessage)) {
            echo '<h1 class="alert-success">'.$successMessage.'</h1>';
       }
    ?>
    <h1 style="margin-top: 24px;"><?php echo $pageTitle?></h1>
    <table>
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>Ảnh sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th>Ngày tạo</th>
                <th>Loại sản phẩm</th>
                <th>Lựa chọn</th>

            </tr>
        </thead>
        <tbody>
            <?php
                foreach($data as $key => $product) {
                    echo ' <tr>
                                <td>'.$product['product_id'].'</td>
                                <td>
                                    <img src="Public/images/'.$product['image'].'" alt="Ảnh của product"/>
                                </td>
                                <td>'.$product['name'].'</td>
                                <td>'.$product['price'].'</td>
                                <td>'.$product['created_at'].'</td>
                                <td>'.$product['category_name'].'</td>
                                <td>
                                    <a class="btn" href="?controller=admin&action=updateProduct&product_id='.$product['product_id'].'">Update</a>
                                    <a class="btn-danger" href="?controller=admin&action=deleteProduct&product_id='.$product['product_id'].'">Delete</a>
                                </td>
                            </tr>';
                }
            ?>
        </tbody>
    </table>
</div>


<?php 
    
    require  'Views/frontend/partials/footer.php';
?>
    
</body>
</html>
