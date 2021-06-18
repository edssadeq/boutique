<?php 
//get products from data base then render html 
require_once("./data_base/connection.php");

$html_content="";

$categ_count = [];

$sql_get_categ = "SELECT * FROM `category`";

$statement = $pdo_conn->query($sql_get_categ);

$categs_array = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($categs_array) {
    foreach ($categs_array as $categ) {
        //var_dump($product);
        $sql_get_count = "SELECT Count(SKU) AS `count` FROM `appartenir` WHERE ID='".$categ['ID']."'";
        $statement2 = $pdo_conn->query($sql_get_count);
        $categ_count = $statement2->fetchAll(PDO::FETCH_ASSOC);
        $html_content .= renderCategoryHTML($categ, $categ_count);
    }
}


function renderCategoryHTML($categ, $categ_count){
    return "
    <li class='list-group-item d-flex justify-content-between align-items-start'>
        <div class='ms-2 me-auto'>
          <div class='fw-bold'><a href='index.php?category=".$categ['ID']."'>".$categ['NAME']."</a></div>
        </div>
        <span class='badge bg-primary rounded-pill'>".$categ_count[0]["count"]."</span>
    </li>
";
}



echo "
<h2>Categories</h2>
<ol class='list-group list-group-numbered'>
  ".$html_content."
</ol>"; //to the page

?>