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

$id = $_GET['id'];

$proucts = $db->prepare("SELECT * FROM products WHERE id=" . $id);
$proucts->execute();
$upd_result = $proucts->fetchAll(PDO::FETCH_ASSOC);

foreach ($upd_result as $upd) {
    $upd_name = $upd['name'];
    $upd_qty = $upd['quantity'];
    $upd_price = $upd['price'];
    $upd_photo_name = $upd['image'];
}

if ($_POST) {
    $name = $_POST['name'];
    $qty = $_POST['quantity'];
    $cat = $_POST['category'];
    $price = $_POST['price'];
    $image_name = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    $file = "../images/" . $image_name;
    $type = pathinfo($file, PATHINFO_EXTENSION);

    if ($type != "png" && $type != "jpg" && $type != "jpeg") {
        echo "<script>Please choose valid photo!.</script>";
    } else {
        move_uploaded_file($tmp, $file);

        $update_db = $db->prepare("UPDATE products SET name='$name',category='$cat',quantity='$qty',price='$price',image='$image_name' WHERE id='$id'");
        $updated = $update_db->execute();
        if ($updated) {
            echo "<script>alert('Data is successfully updated.')</script>";
            header("location: product.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update info</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=".././css/bootstrap.min.css">
    <link rel="stylesheet" href=".././css/adminlte.min.css">
    <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <h1>Updat Products Info By Admin</h1>
        <div class="row">
            <div class="card-body p-0">
                <form method="POST" enctype="multipart/form-data" action="">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Name" value="<?= escape($upd_name) ?>">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control select2" name="category">
                                <?php
                                    $stat = $db->prepare("SELECT * FROM products WHERE id=".$id);
                                    $stat->execute();
                                    $result = $stat->fetchAll(PDO::FETCH_OBJ);

                                    foreach ($result as $value) :
                                    ?>
                                    <option value="<?php if($value->id == $id) ?>" selected><?= escape($value->category) ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Quantity</label>
                            <input type="number" name="quantity" class="form-control" placeholder="quantity" value="<?= escape($upd_qty) ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Price</label>
                            <input type="text" name="price" class="form-control" placeholder="price" value="<?= escape($upd_price) ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Select Photo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile"></label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success">Update</button>
                        <a href="./product.php" class="btn btn-primary">Go Products</a>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>