<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
    header('location: login.php');
}

if ($_SESSION['role'] < 1) {
    header("location: 404.php?Unauthorized=true");
    die();
}

require("../config/config.php");
require("../config/common.php");

    $statement = $db->prepare("SELECT * FROM sale_orders");
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orderd Lists</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Item</th>
                        <th scope="col">Qty</th>
                        <th scope="col">TotalPrice</th>
                        <th scope="col">Order_Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    <?php foreach ($res as $all) : ?>
                        <tr>
                            <th scope="row"><?= escape($count) ?></th>
                            <td><?= escape($all['name']) ?></td>
                            <td><?= escape($all['product_id']) ?></td>
                            <td><?= escape($all['qty']) ?></td>
                            <td><?= escape($all['total_price']) ?></td>
                            <td><?= escape($all['order_date']) ?></td>
                        </tr>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="./product.php" class="btn btn-primary">Go Products</a>
        </div>
    </div>
</body>

</html>