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
    <h1 style="margin-top: 24px;"><?php echo $pageTitle?></h1>
    <?php
    // Các trạng thái thanh toán có thể chọn
    $paymentStatusOptions = array(
        'pending approval',
        'delivery',
        'successful delivery',
        'completed',
        );
    ?>
    <table>
        <thead>
            <tr>
                <th>Payment id</th>
                <th>Amount</th>
                <th>Order date</th>
                <th>Order Status</th>
                <th>Order Method</th>
                <th>User id</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order) { ?>
                <tr>
                    <td><?php echo $order['payment_id']; ?></td>
                    <td><?php echo $order['amount']; ?></td>
                    <td><?php echo $order['payment_date']; ?></td>
                    <td>
                        <form method="POST" action="?controller=admin&action=updatePaymentStatus">
                            <input type="hidden" name="payment_id" value="<?php echo $order['payment_id']; ?>">
                            <select name="payment_status" onchange="this.form.submit()">
                                <?php foreach ($paymentStatusOptions as $status) { ?>
                                    <option value="<?php echo $status; ?>" <?php echo ($order['payment_status'] === $status) ? 'selected' : ''; ?>>
                                        <?php echo $status; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </form>
                    </td>
                    <td><?php echo $order['payment_method']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                </tr>
                <?php } ?>
        </tbody>
    </table>

</div>

    
</body>
</html>
