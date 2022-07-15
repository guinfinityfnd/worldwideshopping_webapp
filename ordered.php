<?php
session_start();

unset($_SESSION['cart']);

// require "./config/config.php";
// if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
//     header('location: login.php');
// }

// if (isset($_SESSION['cart'])) {

//     foreach ($_SESSION['cart'] as $key => $qty) {
//         $id = str_replace('id', '', $key);

//         $name = $_SESSION['user_name'];

//         $statemt = $db->prepare("SELECT * FROM products WHERE id=" . $id);
//         $statemt->execute();
//         $result = $statemt->fetch(PDO::FETCH_ASSOC);
//         $totalp = $result['price'] * $qty;

//         $stmt = $db->prepare("INSERT INTO sale_orders (name,product_id,qty,total_price) VALUES (:name,:product_id,:qty,:total_price)");
//         $stmt->execute([
//             ":name" => $name,
//             ":product_id" => $id,
//             ":qty" => $qty,
//             ":total_price" => $totalp,
//         ]);
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ordered items</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>
<style>
    .card {
        position: absolute;
        top: 50%;
        right: 50%;
        transform: translate(50%, -50%);
        box-shadow: 5px 10px 8px 10px #888888;
    }
</style>

<body style="background-color: lightblue;">
    <button class="btn btn-secondary w-100" style="height: 100vh; position:absolute; z-index:1;" type="button">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="visually-show">Ordering...</span>
    </button>
    <div class="card">
        <img src="./images/giphy.gif" style="width: 100%;" class="card-img-top border border-radius-2" alt="...">
        <div class="card-body">
            <p class="card-text text-center text-success">Thank You For Ordering.
            <pre class="text-center">We will redirct to Home after 3s.</pre><a href="./index.php" id="click" type="hidden"></a></p>
        </div>
    </div>
</body>
<script>
    const spinner = document.querySelector('.btn');
    const click = document.querySelector('#click');

    window.addEventListener('load', () => {
        setTimeout(() => {
            spinner.style.display = 'none';
            setTimeout(() => {
                click.click();
            }, 3000);
        }, 2000);
    });
</script>

</html>