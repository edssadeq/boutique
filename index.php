<?php 

	require_once("./partials/header_part.php");
	//require_once("./data_base/connection.php");
  	require_once("./partials/navbar_part.php");
?>

<div class="container">
	<div class="row">
		<div class="mx-auto col col-12">
			<div id="mycart">
				<div class='modal fade' id='card_modal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
				  <div class='modal-dialog'>
				    <div class='modal-content'>
				      <div class='modal-header'>
				        <h5 class='modal-title' id='exampleModalLabel'>Your Cart</h5>
				        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
				      </div>
				      <div class='modal-body'>
				        <ol id="mycart_list" class='list-group list-group-numbered'>
				          <!-- products here  -->
				          Your cart is empty
				        </ol>
				      </div>
				      <div class='modal-footer'>
				        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
				        <button type='button' class='btn btn-danger' id="delete_all_btn" >Delete all</button>
				        <a href="order.php"><button type='button' class='btn btn-warning text-dark'>Order</button></a>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5">
		<aside class="col-3">
			<?php require_once("./categories.php"); ?>
		</aside>
		<aside class="col-9">
			<div class="row">
				<div class="col-6 mx-auto" id="pagination">
					<?php require_once("./pagination.php"); ?>
				</div>
			</div>
			<?php require_once("./products.php"); ?>
		</aside>
	</div>
</div>


<?php 
	print_r($_SESSION['cart_prods']);
	require_once("./partials/footer_part.php");
?>
