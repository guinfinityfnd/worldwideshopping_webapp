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

require "../config/common.php";
require "../config/config.php";

if ($_POST) {
  $name = $_POST['name'];
  $desc = $_POST['desc'];
  $category = $_POST['category'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  $image = $_FILES['photo'];
  $image_name = $_FILES['photo']['name'];
  $image_type = $_FILES['photo']['type'];
  $tmp = $_FILES['photo']['tmp_name'];

  $file = "../images/" . $image_name;
  $type = pathinfo($file, PATHINFO_EXTENSION);

  if ($type != "png" && $type != "jpg" && $type != "jpeg") {
    echo "<script>Please choose valid photo!.</script>";
  } else {
    move_uploaded_file($tmp, $file);

    $Insert_db = $db->prepare("insert into products (name,description,category,quantity,price,image) values (:name,:description,:category,:quantity,:price,:image)");
    $Insert_db->execute([
      ":name" => $name,
      ":description" => $desc,
      ":category" => $category,
      ":quantity" => $quantity,
      ":price" => $price,
      ":image" => $image_name,
    ]);
    echo "<script>alert('Data is successfully inserted.')</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Add</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href=".././css/bootstrap.min.css">
  <link rel="stylesheet" href=".././css/adminlte.min.css">
  <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <form method="POST" enctype="multipart/form-data" action="product_add.php">
        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Description</label>
            <textarea class="form-control" name="desc" placeholder="Description"></textarea>
          </div>
          <div class="form-group">
            <label>Category</label>
            <select class="form-control select2" name="category">
              <option selected="selected">T-shirt</option>
              <option>Shoe</option>
              <option>Coat</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Quantity</label>
            <input type="number" name="quantity" class="form-control" placeholder="quantity">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Price</label>
            <input type="text" name="price" class="form-control" placeholder="price">
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Select Photo</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
            </div>
            <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div> -->
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="./product.php" class="btn btn-primary">Go Products</a>
          </div>
      </form>
    </div>
  </div>
</body>

</html>