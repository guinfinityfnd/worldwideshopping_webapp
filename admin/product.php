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

$proucts = $db->prepare("SELECT * FROM products");
$proucts->execute();
$product_result = $proucts->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=".././css/bootstrap.min.css">
    <link rel="stylesheet" href=".././css/adminlte.min.css">
    <script src="../js/bootstrap.bundle.min.js" defer></script>
    <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:10px;">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Updated_at</th>
                            <th>Created_at</th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dropdown button
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="./product_add.php">Add-product</a></li>
                                        <li><a class="dropdown-item" href="./ordered_info.php">Ordered-items</a></li>
                                        <li><a class="dropdown-item" href="./Allusers.php">Show-all users</a></li>
                                        <li><a class="dropdown-item" href="../index.php">Go Home</a></li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 0; ?>
                        <?php foreach ($product_result as $x) : ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= escape($x['name']) ?></td>
                                <td><?= escape($x['description']) ?></td>
                                <td><?= escape($x['category']) ?></td>
                                <td><?= escape($x['quantity']) ?></td>
                                <td><?= escape($x['price']) ?></td>
                                <td><?= escape($x['image']) ?></td>
                                <td><?= date("y-m-d"); ?></td>
                                <td><?= escape($x['updated_at']) ?></td>
                                <td colspan="2">
                                    <a href="./update.php?id=<?= $x['id'] ?>" class="btn btn-danger d-block">Edit</a>
                                </td>
                                <?php $id++; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>