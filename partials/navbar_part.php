<?php 
  require_once("./data_base/connection.php");
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Boutique</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
      </ul>
      <div class="d-flex">
        <?php if(isset($_SESSION['loggedin']) && !empty($_SESSION['loggedin']) && isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {?>
          <a class="me-1" href="index.php" style="text-decoration: none;">
            <button class="btn btn-success btn-sm"><i class="fas fa-user"></i><span class="badge bg-success"><?=$_SESSION['username']?></span></button>
          </a>
          <button class="btn btn-primary btn-sm me-1" title="cart" id="cart_button"  data-bs-toggle='modal' data-bs-target='#card_modal'><i class="fas fa-shopping-basket"></i>
            <span class="badge rounded-pill bg-warning text-dark" id="total_items">0</span>
          </button>
          <a class="me-1" href="login.php?logout=true"><button class="btn btn-primary btn-sm" title="logout"><i class="fas fa-sign-out-alt"></i></button></a>
        <?php } else {?>
          <a class="me-1" href="login.php"><button class="btn btn-primary btn-sm" title="logIn"><i class="fas fa-sign-in-alt"></i></button></a>
          <a class="" href="singin.php"><button class="btn btn-primary btn-sm" title="SingIn"><i class="fas fa-user-plus"></i></button></a>
        <?php }?>
      </div>
    </div>
  </div>
</nav>
<?php 
  //var_dump($_SESSION);
?>