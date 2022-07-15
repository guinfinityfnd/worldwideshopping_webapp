<?php
session_start();

require("./config/config.php");
require("./config/common.php");

 if($_POST){
  $email = $_POST["email"];
  $password = $_POST["password"];

  $statement = $db->prepare("SELECT * FROM users WHERE email=:email");
  $statement->execute([':email'=>$email]);

  $user = $statement->fetch(PDO::FETCH_ASSOC);
  if ($user) {
    if(password_verify($password,$user['password'])){
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['logined'] = time();
      $_SESSION['role'] = $user['role'];
      // $_SESSION['photo'] = $user['photo'];

      header('location: index.php');
    }
  }
    echo "<script>alert('email or password is incorrect');</script>";  
 }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>login</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
  </head>
    <style>
      body{
        background-color: lightskyblue ;
        }
</style>
  <body>
    <div class="container login">
      <div class="row">
          <h2 class="text-center mb-5" style="text-shadow:2px 2px darkolivegreen;">
          <img src="./images/world_wide_logo.png" alt="logo" width="80px" height="60px">
          Worldwide Shopping</h2>
          <form method="post" action="login.php">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
            <h3 class="text-center">Sign-In Account</h3>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="exampleInputPassword1">
              <div id="emailHelp" class="form-text">Supported encryption password.</div>
            </div>
            <div class="mb-3">
              <a href="./register.php" class="text-decoration-none">Create a new account!.</a>
            </div>
            <button type="submit" class="btn btn-primary">sign in</button>
          </form>
      </div>
    </div>
  </body>
</html>
