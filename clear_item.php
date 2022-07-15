<?php
    session_start();
    if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
        header('location: login.php');
      }

    unset($_SESSION['cart']['id'.$_GET['pid']]);

    header("location: cart.php");
?>