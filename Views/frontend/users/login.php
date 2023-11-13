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
    <h1><?php echo $title ?></h1>
    <form action="?controller=login&action=login" method="POST">
        <label for="user_name">Nhập tên đăng nhập</label>
        <input type="text" name="user_name" id="user_name" placeholder="Tên đăng nhập...">
        <br />
        <label for="password">Nhập password</label>
        <input type="text" name="password" id="password" placeholder="Mật khẩu...">

        <button type="submit">Đăng nhập</button>
    </form>
</div>


<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
