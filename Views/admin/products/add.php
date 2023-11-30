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
    <a style="margin-bottom: 24px;" class="btn" href="?controller=admin&action=index">Quay lại trang danh sách</a>
    <form style="margin-top: 24px;" action="?controller=admin&action=addProduct" method="post" enctype="multipart/form-data">
        <label for="name">Nhập tên sản phẩm:</label>
        <input required type="text" id="name" name="name"><br><br>

        <label for="price">Giá:</label>
        <input required type="number" id="price" name="price"><br><br>

        <label for="category_id">Chọn loại sản phẩm:</label>
        <select id="category_name" name="category_id">
            <?php 
                foreach($categories as $category) {
                    echo '<option value="'.$category['category_id'].'">'.$category['category_name'].'</option>';
                }
            ?>
        </select><br><br>

        <label for="image">Ảnh:</label>
        <input required type="file" id="image" name="image"><br><br>

        <input required type="submit" value="Submit">
    </form>

</div>

    
</body>
</html>
