<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require "./config/config.php";
// require "./config/common.php";

if ($_POST) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $phone = $_POST["phone"];
  $rePassword = $_POST["re_password"];
  $address = $_POST['address'];
  $photo = $_FILES["photo"];
  $photo_name = $_FILES["photo"]['name'];
  $tmp = $_FILES["photo"]['tmp_name'];

  $file = "./images/" . $photo_name;
  $type = pathinfo($file, PATHINFO_EXTENSION);

  $statement = $db->prepare("SELECT * FROM users WHERE email=:email");
  $statement->execute([':email' => $email]);

  $user = $statement->fetch(PDO::FETCH_ASSOC);
   
    if (!empty($email) && !empty($address) && !empty($password)) {
      if (strlen($password) < 5) {
        echo "<script>alert('Password at least 5 characters need!.')</script>";
      } else {
        if ($password != $rePassword) {
        echo "<script>alert('ooh!password does not match!.');</script>";
        } else {           
          if ($user['email'] == $email) {
            echo "<script>alert('This email is already exits!')</script>";
        } else {
            if(strlen($address) < 10){
              echo "<script>alert('Under 10 words address are not allowed!.')</script>";
          }else{
              if($type != 'jpg' && $type != 'jpeg' && $type != 'png'){
              echo "<script>alert('Please choose png,jpeg,jpg!.');</script>";
            }else{
              //insert into database////////////////////////
              move_uploaded_file($tmp, $file);
    
              $statmt = $db->prepare("INSERT INTO users (name,email,password,phone,address,photo) VALUES (:name,:email,:password,:phone,:address,:photo)");
              $statmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":password" => password_hash($password,PASSWORD_DEFAULT),
                ":phone" => $phone,
                ":address" => $address,
                ":photo" => $photo_name,
              ]);
              header("location: login.php?registered=true");
            }
          }
        }
      }
    }
    }
}
?> 

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>socalblog | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/adminlte.min.css">
  <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
</head>

<body class="hold-transition register-page">
  <div class="register-box" style="box-shadow: 0px 5px 14px black;">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h1"><b>World</b>Shopping</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg text-success">Register a new membership</p>

        <form action="register.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control <?php if (isset($_POST['name']) == " ") {
                                                                  echo "is-invalid";
                                                                } ?>" value="<?php if (isset($name)) {
                                                                                                        echo "$name";
                                                                                                      } ?>" placeholder="name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control <?php if (isset($_POST['email']) == " ") {
                                                                    echo "is-invalid";
                                                                  } ?>" value="<?php if (isset($email)) {
                                                                                                      echo "$email";
                                                                                                    } ?>" placeholder="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="tel" maxlength="11" pattern="[0-9]{2}[0-9]{5}[0-9]{4}" name="phone" class="form-control <?php if (isset($_POST['phone']) == " ") {
                                                                    echo "is-invalid";
                                                                  } ?>" value="<?php if (isset($phone)) {
                                                                                                      echo "$phone";
                                                                                                    } ?>" placeholder="Phone Number">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control <?php if (isset($_POST['password']) == " ") {
                                                                          echo "is-invalid";
                                                                        } ?>" value="<?php if (isset($password)) {
                                                                                                              echo "$password";
                                                                                                            } ?>" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="re_password" class="form-control <?php if (isset($_POST['password']) == " ") {
                                                                          echo "is-invalid";
                                                                        } ?>" value="" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <textarea name="address" class="form-control <?php if (isset($_POST['address']) == " ") {
                                                                          echo "is-invalid";
                                                                        } ?>" value="<?php if (isset($address)) {
                                                                                                              echo "$address";
                                                                                                            } ?>" id="address" cols="30" maxlength="150" rows="3" placeholder="Address"></textarea>
          </div>
          <div class="mb-3">
            <label for="formFileSm" class="form-label">Choose your profile photo</label>
            <input class="form-control-sm" name="photo" id="formFileSm" type="file">
          </div>
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </form><br>
        <a href="login.php" class="text-center">I already have an account.</a>
      </div>
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>

</html>