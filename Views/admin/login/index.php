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

    // require  'Views/frontend/partials/header_admin.php' ;

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>

<div style="margin-top: 24px;" class="container">
    <?php 
        if(!empty($errorMessage)) {
            echo '<h1 class="alert-warning">'.$errorMessage.'</h1>';
        }
    ?>
    <form action="?controller=admin&action=login" method="POST">
        <label style="width: 200px; font-size: 20px; display: inline-block; margin-top: 12px;" for="user_name">Nhập tên đăng nhập</label>
        <input style="padding: 8px 16px; font-size: 18px; border: 1px solid #ccc; border-radius: 4px;" type="text" name="user_name" id="user_name" placeholder="Tên đăng nhập...">
        <br />
        <label style="width: 200px; font-size: 20px; display: inline-block; margin-top: 12px;" for="password">Nhập password</label>
        <input id="passwordField" style="padding: 8px 16px; font-size: 18px; border: 1px solid #ccc; border-radius: 4px;" type="password" name="password" id="password" placeholder="Mật khẩu...">
        <br />
        <input id="passwordToggle" style="margin-left: 205px; margin-top: 8px" type="checkbox" >
        <label for="passwordToggle">Hiển thị mật khẩu</label>
        <br />
        <button style="margin: 30px 0 0 142px;" class="btn" type="submit">Đăng nhập bằng Admin</button>
    </form>

</div>

    
</body>
</html>
