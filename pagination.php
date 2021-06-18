<?php 
	require_once("./data_base/connection.php");

	

	$products_count = $pages_number = 0;

	if(isset($_GET['category']) && !empty($_GET['category'])){
		$sql = "SELECT COUNT(SKU) AS products_count FROM `appartenir` WHERE ID='".$_GET['category']."'";
		$statement = $pdo_conn->query($sql);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if ($result) {
			$products_count = $result[0]["products_count"];
		}
		$pages_number = $products_count % LIMIT == 0 ? $products_count / LIMIT :  $products_count / LIMIT +1;
		echo renderPagination($pages_number, "index.php?category=".$_GET['category']."&page_cat=");
	}
	else{
		$sql = "SELECT COUNT(*) as products_number FROM `produit`";
		$statement = $pdo_conn->query($sql);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if ($result) {
			$products_count = $result[0]["products_number"];
		}
		$pages_number = $products_count % LIMIT == 0 ? $products_count / LIMIT :  $products_count / LIMIT +1;
		echo renderPagination($pages_number, "index.php?page=");
	}


	function renderPagination($pages_number, $href_to){

		$paginationLinksHTML = "";
		for ($i=1; $i <= $pages_number  ; $i++) { 
			$paginationLinksHTML.="<li class='page-item'><a class='page-link' href='".$href_to."".$i."'>".$i."</a></li>";
		}

		return "<nav aria-label='priducts_pagination'>
		  <ul class='pagination pagination-md'>
		    ".$paginationLinksHTML."
		  </ul>
		</nav>";
	}

?>