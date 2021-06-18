<?php 
	require_once("./partials/header_part.php");
	require_once("./partials/navbar_part.php");
	require_once("./data_base/connection.php");

	//logginh out 

	if (isset($_GET['logout'])) {
	    if($_GET['logout'] == true){
	      // If it's desired to kill the session, also delete the session cookie.
			// Note: This will destroy the session, and not just the session data!
			if (ini_get("session.use_cookies")) {
			    $params = session_get_cookie_params();
			    setcookie(session_name(), '', time() - 42000,
			        $params["path"], $params["domain"],
			        $params["secure"], $params["httponly"]
			    );
			}

			// Finally, destroy the session.
			session_destroy();
			header("Location: index.php");
	    }
  	}



$email = $password  = $userId= "";
$email_err = $password_err  = $login_err= "";
$clients_array=[];
// Processing form data when form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["email"]) && isset($_POST["password"])){
 
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Unvalide email address.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM `client` WHERE `USERNAME`= :emailIn";
        $statement = $pdo_conn->prepare($sql);
        $statement->bindParam(':emailIn', trim($_POST["email"]), PDO::PARAM_STR);
		$statement->execute();
		$clients_array = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(count($clients_array)<=0){
				$login_err = "Account not found.";
		}
		else{
			$email = trim($_POST["email"]);
			if(trim($_POST["password"]) != $clients_array[0]["PASSWORD"]){
				$password_err = "Password Incorrect. ";
			}
			else{
				$password = trim($_POST["password"]);
				$userId = $clients_array[0]["ID_CLIENT"];
			}
		}
			
    }
  

    if(empty($email_err) && empty($password_err) && empty($login_err)){
        // Prepare an insert statement
        $username = explode('@', $email)[0];
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $userId;
        header("Location: index.php?username=$username");
    }
    
    // Close connection
    closeConnection($pdo_conn);
}

?>

<div class="container">
	<?php 
		//echo date("Ymd_Gis");

	?>
	<div class="row mt-5">
		<div class="col-6 mx-auto">
			<div class="card">
				<article class="card-body">
					<h4 class="card-title text-center mb-4 mt-1">LOG IN</h4>
					<hr>
					<p class="text-danger text-center"><?= !empty($login_err) ?  $login_err :"" ?></p>
					<form method="post" action="login.php">
					<div class="form-group mb-4">
						<div class="input-group mb-3">
						  <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
						  <input type="email" name="email" class="form-control" placeholder="Email@exemple.com" aria-label="email" aria-describedby="basic-addon1">
						</div>
						<p class="text-danger"><?= !empty($email_err) ?  $email_err :"" ?></p>
					</div> <!-- form-group// -->
					<div class="form-group mb-4">
						<div class="input-group mb-3">
						  <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
						  <input type="password" name="password" class="form-control" placeholder="Password" aria-label="password" aria-describedby="basic-addon1" autocomplete="false">
						</div>
						<p class="text-danger"><?= !empty($password_err) ?  $password_err :"" ?></p>
					</div> <!-- form-group// -->
					<div class="form-group mb-4">
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary btn-block"> Login  </button>
						</div>
					</div> <!-- form-group// -->
					<p class="text-center"><a href="#" class="btn">Forgot password?</a></p>
					</form>
				</article>
			</div>
		</div>
	</div>
</div>


<?php 
	require_once("./partials/footer_part.php");
?>



