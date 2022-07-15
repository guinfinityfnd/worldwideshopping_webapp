<?php 
session_start(); 

if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
  header('location: login.php');
}
  require("./config/config.php");
  require("./config/common.php");
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>cart</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>

<body class="bg bg-dark mt-2">
  <h2 class="text-light text-center d-flex justify-content-around" >
    <a href="index.php" class="btn btn-light">Go Home</a>
    <span>Your Order Items</span>
  </h2><hr style="color: #fff;">
  <div class="container cart-container">
    <div class="row">
      <table class="table table-striped bg bg-light">
        <thead class="position-sticky top-0">
          <tr class="bg bg-dark text-light">
            <th scope="col">Photo</th>
            <th scope="col">Item Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Remove Items</th>
          </tr>
        </thead>
        <!-- table data is start -->
        <?php if(empty($_SESSION['cart'])) { ?>
          <tbody>
              <tr>
                <td class="text-danger text-center" colspan="5">You haven't choosen yet!.</td>
              </tr>
          </tbody>
          <?php } else { ?>
            <tbody>
          <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $key => $qty) : 
              $id = str_replace('id','',$key);

              $stmt = $db->prepare("SELECT * FROM products WHERE id=".$id);
              $stmt->execute();
              $res = $stmt->fetch(PDO::FETCH_ASSOC);

              $total += $res['price'] * $qty;
              ?>
            <tr>
            <th scope="row">
              <img src="./images/<?= escape($res['image']) ?>" alt="photo" width="100px" height="50px" object-fit="cover">
            </th>
            <td><?= escape($res['name']) ?></td>
            <td><?= escape($qty) ?></td>
            <td>$<?= escape($res['price']) * $qty ?></td>
            <td>
              <a href="clear_item.php?pid=<?= escape($res['id']) ?>" class="btn btn-primary d-block">Remove</a>
            </td>
          </tr>
        </tbody>
        <?php endforeach; ?>
        <tr>
          <td class="text-center text-success" colspan="3">TOTALPRICE</td>
          <td class="text-danger">$<?= escape($total) ?></td>
          <td>
            <a href="./ordered.php" class="btn btn-info">Order Now</a>
          </td>
        </tr>
            <?php } ?>
        <!-- table data is stop -->
      </table>
    </div>
  </div>
</body>
</html>