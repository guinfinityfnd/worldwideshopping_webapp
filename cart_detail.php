<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
  header('location: login.php');
}

require("./config/config.php");
// require("./config/common.php");

$id = $_POST['id'];
$qty = $_POST['qty'];

if($qty < 0 ){
  echo "<script>alert('\"-\"values are not allowed!.');
  window.location.href='product_detail.php?id=$id'</script>";
  exit();
}else if($qty == 0){
  echo "<script>alert('\"0\"value is not allowed!.');
  window.location.href='product_detail.php?id=$id'</script>";
  exit();
}

if ($_POST) {
  
  if(is_numeric($qty) != 1){
    echo "<script>alert('Count must be number!.');window.location.href='product_detail.php?id=$id'</script>";
  }

  $statement =  $db->prepare("SELECT * FROM products WHERE id=".$id);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);

  if ($qty > $result['quantity']) {
    echo "<script>alert('Not enough stock.');
          window.location.href='product_detail.php?id=$id'</script>";
  } else {
    if (isset($_SESSION['cart']['id'.$id])) {
        $_SESSION['cart']['id'.$id] += $qty;
    } else {
      $_SESSION['cart']['id'.$id] = $qty;
    }
    header("location: product_detail.php?id=".$id);
  }
}
