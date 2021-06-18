<?php
require("./connection.php");

/*
the next line to fixe the exception :
Fatal error: Allowed memory size of 134217728 bytes exhausted (tried to allocate 24 bytes)
*/
//ini_set('memory_limit', '1024M'); //G

//read json file
$products_json = file_get_contents("./products.json");
//convert json object to php associative array
$products_data = json_decode($products_json, true);

$products_needed  = 101;
$categories = []; //to prevent reapetation
foreach ($products_data as  $product){
    if($products_needed == 0) break; // stop afer getting 100 products
    //echo $product['sku']."<br>";

    // prepare sql and bind parameters
    $insert_products = $pdo_conn->prepare("INSERT INTO 
    `produit`(`SKU`, `NAME`, `TYPE`, `PRICE`, `UPC`, `SHIPPING`, `DESCRIPTION`, `MANUFACTURER`, `MODEL`, `URL`, `IMAGE`)
     VALUES (?,?,?,?,?,?,?,?,?,?,?)");

    $insert_products->execute([$product['sku'],$product['name'],$product['type'],$product['price'],$product['upc'],$product['shipping'],$product['description'],$product['manufacturer'],$product['model'],$product['url'],$product['image']]);

    $product_categories = $product['category'];
    foreach ($product_categories as $category){

        if(!in_array($category['id'], $categories)){
            $insert_categ = $pdo_conn->prepare("INSERT INTO `category`(`ID`, `NAME`) VALUES (?,?)");
            $insert_categ->execute([$category['id'], $category['name']]);
            array_push($categories, $category['id']);
        }

        $insert_poduct_categ = $pdo_conn->prepare("INSERT INTO `appartenir`(`SKU`, `ID`) VALUES (?,?)");
        $insert_poduct_categ->execute([$product['sku'], $category['id']]);
    }

    $products_needed --;
}
