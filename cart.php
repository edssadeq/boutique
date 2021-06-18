<?php
  require_once("./data_base/connection.php");

    if(isset($_POST['total_cart_items']))
    {
      if(isset($_SESSION['username'])){
        //echo isset($_SESSION['prod_id']) ? count($_SESSION['prod_id']) : 0; //responce
        echo isset($_SESSION['cart_prods']) ? count($_SESSION['cart_prods']) : 0; //responce
        exit();
      }
    	
    }

    if(isset($_POST['prod_id']))
    {
      //if(in_array(needle, haystack))

      if(isset($_SESSION['username'])){
        $_SESSION['cart_prods'];
        if(isset($_SESSION['cart_prods']) && !is_product_in_cart($_SESSION['cart_prods'], $_POST['prod_id'])){
          $_SESSION['cart_prods'][] = [ 'prod_id'=>$_POST['prod_id'],
                                      'prod_name'=>$_POST['prod_name'],
                                      'prod_price'=>$_POST['prod_price'],
                                      'prod_shipping'=>$_POST['prod_shipping'],
                                      'prod_quantity'=>$_POST['prod_quantity']];
        }

        //echo count($_SESSION['prod_id']);
        echo isset($_SESSION['cart_prods']) ? count($_SESSION['cart_prods']) : 0;
        exit();
      }
      else{
        header("Location:login.php");
      }
    }

    function is_product_in_cart($cart, $prod_id){
      foreach($cart as $product){
        if($product['prod_id'] == $prod_id) return 1;
      }
      return 0;
    }

    //show cart
    if(isset($_POST['showcart']) && isset($_SESSION['cart_prods']))
    {
      if(isset($_SESSION['username'])){
        for($i=0;$i<count($_SESSION['cart_prods']);$i++)
        {
          echo renderListItem($i);
        }

        exit();	
      }
      else{
        header("Location:login.php");
      }
    }

    // $total_payment = 0;

    if(isset($_POST['delete_item']) && isset($_SESSION['cart_prods']))
    {
      if(isset($_SESSION['username'])){
        $item_index = $_POST['delete_item']; 
        //unset($_SESSION['cart_prods'][$item_index]); //delete item and re_render cart
        array_splice($_SESSION['cart_prods'],  $item_index, 1); //delete item (start index, range)
        for($i=0;$i<count($_SESSION['cart_prods']);$i++)
        { 
          $total_payment += (floatval($_SESSION['cart_prods'][$i]['prod_price']) * floatval($_SESSION['cart_prods'][$i]['prod_quantity']) + floatval($_SESSION['cart_prods'][$i]['prod_shipping']));

          echo renderListItem($i);
        }

        exit(); 
      }
      else{
        header("Location:login.php");
      }
    }

    // $_SESSION['user_total_payment'] = $total_payment;
    
    //empty cart
    if(isset($_POST['delete_cart_items'])){
      if(isset($_SESSION['username'])){
        //array_splice($_SESSION['cart_prods'],  $item_index, 1);
        if(isset($_SESSION['cart_prods'])){
          $_SESSION['cart_prods']=[];
          echo count($_SESSION['cart_prods']);
        }
        
        exit(); 
      }
      else{
        header("Location:login.php");
      }
    }
    

    function renderListItem($i){
      $total = floatval($_SESSION['cart_prods'][$i]['prod_price']) * floatval($_SESSION['cart_prods'][$i]['prod_quantity']) + floatval($_SESSION['cart_prods'][$i]['prod_shipping']);
      return "
        <li class='list-group-item d-flex justify-content-between align-items-start'>
          <div class='ms-2 me-auto'>
            <div class='fw-bold'>".$_SESSION['cart_prods'][$i]['prod_name']."</div>
            <span class='badge bg-light text-dark'>Price: $".$_SESSION['cart_prods'][$i]['prod_price']."</span>
            <span class='badge bg-light text-dark'>Quantity: ".$_SESSION['cart_prods'][$i]['prod_quantity']."</span>
            <span class='badge bg-light text-dark'>Shipping: $".$_SESSION['cart_prods'][$i]['prod_shipping']."</span>
            <div class='row mt-1'>
              <div class='col'>
               <button type='button' class='btn btn-outline-danger btn-sm btn_delete_item' data-index='".$i."' ><span class='badge bg-danger '><i class='fas fa-minus'></i></span> Delete item</button>
              </div>
            </div>
          </div>
          <span class='badge bg-warning text-dark rounded-pill' style='font-size:15px;'>$".$total."</span>
        </li>
      ";
    }
?>

