<?php 
	require_once("./partials/header_part.php");
	require_once("./partials/navbar_part.php");
	require_once("./data_base/connection.php");


$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = $singin_err= "";
$lastInsertId ="";
 
// Processing form data when form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_conf"])){
 
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Unvalide email address.";
    } else{
        // Prepare a select statement
        $sql = "SELECT `ID_CLIENT` FROM `client` WHERE `USERNAME`= :emailIn";
        $statement = $pdo_conn->prepare($sql);
        $statement->bindParam(':emailIn', trim($_POST["email"]), PDO::PARAM_STR);
		$statement->execute();
		$clients_array = $statement->fetchAll(PDO::FETCH_OBJ);
		if(count($clients_array)>0){
				$email_err = "This email is already taken.";
		}
		else{
			$email = trim($_POST["email"]);
		}
			
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 4){
        $password_err = "Password must have at least 4 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["password_conf"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["password_conf"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($singin_err)){
        // Prepare an insert statement
        $sql_insert = "INSERT INTO `client`(`USERNAME`, `PASSWORD`) VALUES (:email,:password)";
         $insert_client = $pdo_conn->prepare($sql_insert);
         $insert_client-> bindParam(':email', $email, PDO::PARAM_STR);
         $insert_client-> bindParam(':password', $password, PDO::PARAM_STR);
         $insert_client->execute();
         $lastInsertId = $pdo_conn->lastInsertId();
         if(!empty($lastInsertId)){
         	header("location: login.php");
         }else{
         	$singin_err = "Sing in failure!";
         }
    }
    
    // Close connection
    closeConnection($pdo_conn);
}


?>

<div class="container">
	
	<div class="row mt-5">
		<div class="col-6 mx-auto">
			<div class="card">
				<article class="card-body">
					<h4 class="card-title text-center mb-4 mt-1">SING UP</h4>
					<hr>
					<p class="text-danger text-center"><?= !empty($singin_err) ?  $singin_err :"" ?></p>
					<form method="post" action="singin.php">
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
						<div class="input-group mb-3">
						  <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
						  <input type="password" name="password_conf" class="form-control" placeholder="Confirm Password" aria-label="password" aria-describedby="basic-addon1" autocomplete="false">
						</div>
						<p class="text-danger"><?= !empty($confirm_password_err) ? $confirm_password_err :"" ?></p>
					</div> <!-- form-group// -->
					<div class="form-group mb-4">
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary btn-block"> Singin  </button>
						</div>
					</div> <!-- form-group// -->
					</form>
				</article>
			</div>
		</div>
	</div>
</div>


<?php 
	require_once("./partials/footer_part.php");
?>
