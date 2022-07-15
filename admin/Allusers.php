<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require("../config/config.php");
require("../config/common.php");

if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
    header('location: login.php');
}

if ($_SESSION['role'] < 1) {
    header("location: 404.php?Unauthorized=true");
    exit();
}

try {
    $stam = $db->prepare("SELECT * FROM users");
    $stam->execute();
    $user_records = $stam->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "not connected" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid bg-dark">
        <div class="row card-body table-responsive p-0">
            <!-- users data -->
            <!-- <div class="" style="height: 300px;"> -->
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr class="text-danger">
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Photo</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($user_records as $alluser) : ?>
                            <tr class="text-success">
                                <td><?= escape($i); ?></td>
                                <td><?= escape($alluser->name) ?></td>
                                <td><?= escape($alluser->email) ?></td>
                                <td><?= escape($alluser->phone) ?></td>
                                <td><?= escape($alluser->address) ?></td>
                                <td><img src="../images/<?= escape($alluser->photo) ?>" alt="userphoto" width="50px;" height="50px"></td>
                                <td><?= escape($alluser->created_at) ?></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="./product.php" class="btn btn-danger">Go Products</a>
            <!-- </div> -->
            <!-- users data end-->
        </div>
    </div>
</body>

</html>