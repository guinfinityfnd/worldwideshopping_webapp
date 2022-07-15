<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
  header('location: login.php');
}

require("./config/config.php");
require("./config/common.php");

$getId = $_GET['id'];

$statement =  $db->prepare("SELECT * FROM products WHERE id=" . $getId);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_OBJ);
// print_r($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>product deatils</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/adminlte.min.css">
</head>

<body>
  <div class="container">
    <div class="row mt-4">
      <nav class="navbar bg bg-info d-flex justifiy-content-between">
        <div class="text-light">Worldwide Shopping</div>
        <div class="navbar">
           <?php 
            $cart = 0;
            if(isset($_SESSION['cart'])){
              foreach($_SESSION['cart'] as $key => $qty){
                $cart += $qty;
              }
            }
          ?> 
          <a href="cart.php"><i class="fas fa-cart-arrow-down mx-2 text-light"><span class="badge bg-secondary position-absolute top-0 translate-middle badge rounded-pill bg-danger"><?= escape($cart) ?></span></i></a>
        </div>
      </nav>
      <?php foreach ($result as $a) : ?>
        <form action="./cart_detail.php" method="post">
          <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
          <input type="hidden" name="id" value="<?php echo escape($a->id) ?>">
          <div class="card mb-3">
            <img src="images/<?= escape($a->image) ?>" class="card-img-top" alt="..." style="width:200px;height:200px;object-fit:fill;">
            <div class="card-body">
              <h5 class="card-title">Name : <?= escape($a->name) ?></h5>
              <p class="card-text">Description : <?= escape($a->description) ?></p>
              Count : <input type="number" name="qty" id="number" value="1" style="width: 50px;">
              <hr>
              <p class="card-text"><small class="text-muted">Date : <?= escape(date("d-m-y", strtotime($a->updated_at))) ?></small></p>
              <button href="#" class="btn btn-success w-100">Add To Cart</button><br><br>
              <a href="./index.php" class="btn btn-danger w-100">Back</a>
            </div>
          </div>
        </form>
        <?php endforeach; ?>
    </div>
  </div>
</body>

</html>