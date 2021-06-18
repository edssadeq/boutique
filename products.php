<?php 
//get products from data base then render html 
require_once("./data_base/connection.php");

function getDataAndRender($pdo_conn, $page, $limit){
	$offset = $limit * ($page - 1);
	$html_content="";
	$sql = "SELECT * FROM `produit` LIMIT ".$limit." OFFSET ".$offset."";
	$statement = $pdo_conn->query($sql);

	$products_array = $statement->fetchAll(PDO::FETCH_ASSOC);

	if ($products_array) {
		foreach ($products_array as $product) {
			$html_content .= renderProductHTML($product);
			//var_dump($product);
		}
	}

	return $html_content;

}

function getDataByCategoryAndRender($pdo_conn, $page, $limit, $category_id){
	$offset = $limit * ($page - 1);
	$html_content="";
	
	$sql_select_by_categ = "SELECT SKU FROM `appartenir` WHERE ID='".$category_id."' LIMIT ".$limit." OFFSET ".$offset."";

	$statement1 = $pdo_conn->query($sql_select_by_categ);
	$products_id_array = $statement1->fetchAll(PDO::FETCH_ASSOC);

	if ($products_id_array) {
		foreach ($products_id_array as $product_id) {
			$sql = "SELECT * FROM `produit` WHERE SKU='".$product_id['SKU']."'";
			//echo $sql."<br>"; //**********************
			$statement2 = $pdo_conn->query($sql);
			$products_array = $statement2->fetchAll(PDO::FETCH_ASSOC);
			//var_dump($products_array);
			if($products_array){
				$product = $products_array[0];
				$html_content .= renderProductHTML($product);
			}
			//var_dump($product);
		}
	}

	return $html_content;

}

function renderProductHTML($product){
	$product_html = "";
	$product_html = "
		<div class='card text-center shadow p-3 mb-5 bg-body rounded' style='width: 15rem;'>
		  <img src='".$product['IMAGE']."' class='card-img-top' alt='' style='height:150px;'>
		  <div class='card-body'>
		    <h5 class='card-title fw-bold'>".$product['NAME']."</h5>
		    <p class='card-text'>".$product['TYPE']."/".$product['MODEL']."</p>
		     <ul class='list-group list-group-flush'>
			    <li class='list-group-item fw-bold'>Price: $".$product['PRICE']."</li>
			    <li class='list-group-item'>Shipping: $".$product['SHIPPING']."</li>
			  </ul>
		    <div class='input-group mb-1 mt-2'>
			  <input type='number' class='form-control' id='prod_".$product['SKU']."_quantity' placeholder='number' aria-label='number' aria-describedby='button-addon2'>
			  <button class='btn btn-warning' type='button' id='button-addon2' onclick=\"cart(".$product['SKU'].")\">ADD</button>
			</div>
			<input type='hidden' id='prod_".$product['SKU']."_id' value='".$product['SKU']."'>
			<input type='hidden' id='prod_".$product['SKU']."_name' value='".$product['NAME']."'>
    		<input type='hidden' id='prod_".$product['SKU']."_price' value='".$product['PRICE']."'>
    		<input type='hidden' id='prod_".$product['SKU']."_shipping' value='".$product['SHIPPING']."'>
		  </div>
		</div>
	";
	return "<div class='col'>".$product_html."</div>";
}

$html_content = "";
if(isset($_GET['page']) && !empty($_GET['page'])){
	$html_content = getDataAndRender($pdo_conn, (int)$_GET['page'], LIMIT );
}
else if(isset($_GET['category']) && !empty($_GET['category'])){
	if(isset($_GET['page_cat']) && !empty($_GET['page_cat'])){
		$html_content = getDataByCategoryAndRender($pdo_conn,$_GET['page_cat'], LIMIT, $_GET['category']);
	}
	else{
		$html_content = getDataByCategoryAndRender($pdo_conn,1, LIMIT, $_GET['category']);
	}
	
}
else{
	$html_content = getDataAndRender($pdo_conn, 1, LIMIT );
}

echo "<div class='row'>".$html_content."</div>"; //to the page
?>


