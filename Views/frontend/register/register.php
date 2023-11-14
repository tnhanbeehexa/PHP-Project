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
    <h1><?php echo isset($title) && !empty($title) ? $title : (isset($notification) && !empty($notification) ? $notification : ''); ?></h1>
    <form action="?controller=register&action=register" method="POST">
        <label style="width: 200px; font-size: 20px; display: inline-block; margin-top: 12px;" for="user_name">Nhập tên đăng nhập</label>
        <input style="padding: 8px 16px; font-size: 18px; border: 1px solid #ccc; border-radius: 4px;" type="text" name="user_name" id="user_name" placeholder="Tên đăng nhập..." required>
        <br />
        <label style="width: 200px; font-size: 20px; display: inline-block; margin-top: 12px;" for="emailField">Nhập Email</label>
        <input id="emailField" style="padding: 8px 16px; font-size: 18px; border: 1px solid #ccc; border-radius: 4px;" type="email" name="email" id="email" placeholder="abc@gmail.com" required>
        <br />
        <label style="width: 200px; font-size: 20px; display: inline-block; margin-top: 12px;" for="password">Nhập password</label>
        <input id="passwordField" style="padding: 8px 16px; font-size: 18px; border: 1px solid #ccc; border-radius: 4px;" type="password" name="password" id="password" placeholder="Mật khẩu..." required>
        <br />
        <input id="passwordToggle" style="margin-left: 205px; margin-top: 8px" type="checkbox" > 
        <label for="passwordToggle">Hiển thị mật khẩu</label>
        <br />
        <button style="margin: 30px 0 0 313px" class="btn" type="submit">Đăng kí</button>
    </form>
</div>
<script>
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordField = document.getElementById('passwordField');
        
        // Sử dụng sự kiện onchange để kiểm tra thay đổi trạng thái của checkbox
        passwordToggle.addEventListener('change', function() {
            // Nếu checkbox được chọn, chuyển đổi thành kiểu text
            if (passwordToggle.checked) {
                passwordField.setAttribute('type', 'text');
            } else {
                // Nếu checkbox không được chọn, chuyển đổi lại thành kiểu password
                passwordField.setAttribute('type', 'password');
            }
        });
    </script>

<?php 
    
    require __DIR__ . '/../partials/footer.php';
?>
    
</body>
</html>
