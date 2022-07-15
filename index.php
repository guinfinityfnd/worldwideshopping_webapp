<?php 
  
  session_start();

  if (empty($_SESSION['user_id']) && empty($_SESSION['logined'])) {
    header('location: login.php');
  }

  require("./config/config.php");
  require("./config/common.php");

  $statement =  $db->prepare("SELECT * FROM products");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping App</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/bfc3ef21f1.js" defer crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js" defer></script>
</head>
<style>
  /* width */
::-webkit-scrollbar {
  width: 1px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
} 

  #spinner{
    z-index: 98;
    position:fixed;
    background-color: #000;
    /* opacity: .9; */
    width: 100%;
    height: 100%;
    scroll-behavior: smooth;
}

#spinner>img{
    z-index: 99;
    position:absolute;
    transform: translate(50%,-50%);
    top: 50%;
    right: 50%;
}
</style>
<body style="overflow: auto;">
  <div id="spinner">
    <img src="./images/Gear-0.1s-31px.gif" alt="...">
  </div>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar bg bg-dark d-flex justifiy-content-between">
                    <div class="text-light">
                      <img src="./images/world_wide_logo.png" alt="logo" width="60px" height="60px">
                      Worldwide Shopping</div>
                    <div class="navbar">
                        <a href="./logout.php" class="me-4 btn btn-primary">Logout</a>
                        <a href="./admin/product.php" class="btn btn-primary <?php if ($_SESSION['role'] != 1 ) { echo 'd-none';} ?>">Admin Account</a>
                    </div>
            </nav>
        </div>
    </div>
    <!-- /////slide photo cotainer/// -->
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item">
            <img src="./images/lookbook-2.jpg" class="d-block w-100" alt="">
          </div>
          <div class="carousel-item active">
            <img src="./images/lookbook-4.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/lookbook-3.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
    </div><hr>
    <!-- ////text center line/// -->
    <div class="d-block bg-light text-center mt-2">
        <h2>How It Is Wonderful!.</h2>
        <small>let's play a role.</small>
    </div><hr>
    <!-- /////card items start//// -->
    <div class="container-fluid">
      <div class="row get-container no-gutters">
        <?php foreach ($result as $x) : ?>
        <div class="col-sm-12 col-md-4 col-lg-3">
                    <img src="./images/<?= escape($x->image) ?>" class="card-img-top" alt="image" width="100px" height="200px" object-fit="contain" >
                    <div class="card-body">
                      <h5 class="card-title">Name : <?= escape($x->name) ?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Category : <?= escape($x->category) ?></li>
                      <li class="list-group-item">Price $ : <?= escape($x->price) ?></li>
                      <li class="list-group-item">Quantity : <?= escape($x->quantity) ?></li>
                    </ul>
                    <div class="card-body">
                      <a href="product_detail.php?id=<?= escape($x->id) ?>" class="card-link btn btn-success">View more</a>
                    </div>
                  </div></br>
                  <?php endforeach; ?>
                </div>
              </div>    
    <div class="footer">
      <div class="bg bg-dark text-center">
        <small class="text-light">Copyright &copy;2020-2023.All right Reserved.</small>
      </div>
    </div>
</body>
<script>
  const loading = document.querySelector('#spinner');

  window.addEventListener('load',()=>{
    loading.style.display = "none";
  });
</script>
</html>