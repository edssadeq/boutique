
var mycart_list = document.getElementById("mycart_list");

$(document).ready(function(){
  console.log("hello");
  mycart_list = document.getElementById("mycart_list");
		//get cart items count
      $.ajax({
        type:'post',
        url:'cart.php',
        data:{
          total_cart_items:"totalitems"
        },
        success:function(response) {
          //  if(response.length > 3){
          //   document.getElementById("total_items").textContent=0;
          // }
            document.getElementById("total_items").textContent=response;
          //console.log("total_cart_items : "+response);
        }
      });

    });

	//add to cart
    function cart(prod_id_in)
    {

	  let prod_id = document.getElementById("prod_"+prod_id_in+"_id").value;
	  let prod_name = document.getElementById("prod_"+prod_id_in+"_name").value;
	  let prod_price = document.getElementById("prod_"+prod_id_in+"_price").value;
	  let prod_shipping = document.getElementById("prod_"+prod_id_in+"_shipping").value;
	  let prod_quantity = document.getElementById("prod_"+prod_id_in+"_quantity").value;
        prod_quantity = prod_quantity > 0 ? prod_quantity : 1;

	  $.ajax({
        type:'post',
        url:'cart.php',
        data:{
          prod_id,
          prod_name,
          prod_price,
          prod_shipping,
          prod_quantity
        },
        success:function(response) {
          document.getElementById("total_items").textContent=response;
        }
      });

    }

    $( "#cart_button" ).on( "click", function() {
        $.ajax({
        type:'post',
        url:'cart.php',
        data:{
          showcart:"cart"
        },
        success:function(response) {
          mycart_list.innerHTML= response.length > 0 ? response : "Your cart is empty" ;
          //mycart_list.innerHTML=response;
          //$("#mycart").slideToggle();
        }
       });
    });



    document.addEventListener('click', (e)=>{
      if(e.target.matches(".btn_delete_item")){
        var item_index = e.target.getAttribute("data-index");
          $.ajax({
            type:'post',
            url:'cart.php',
            data:{
              delete_item:item_index
            },
            success:function(response) {
              mycart_list.innerHTML= response.length > 0 ? response : "Your cart is empty" ;
              //$("#mycart").slideToggle();

            }
         });

          $.ajax({
            type:'post',
            url:'cart.php',
            data:{
              total_cart_items:"totalitems"
            },
            success:function(response) {
              //  if(response.length > 3){
              //   document.getElementById("total_items").textContent=0;
              // }
                document.getElementById("total_items").textContent=response;
              //console.log("total_cart_items : "+response);
            }
          });

      }

      //btn_edit_item
      if(e.target.matches(".btn_edit_item")){
        var item_index = e.target.getAttribute("data-index");
        var newQuantity = document.getElementById(`prod_${item_index}_quantity`).value;  //prod_".$i."_quantity
        newQuantity = newQuantity > 0 ? newQuantity : 1;
        //console.log(newQuantity + "=== " + item_index);
          $.ajax({
            type:'post',
            url:'cart.php',
            data:{
              edit_item: item_index,
              newQuantity: newQuantity
            },
            success:function(response) {
              mycart_list.innerHTML= response.length > 0 ? response : "Your cart is empty" ;
              //$("#mycart").slideToggle();

            }
         });

          $.ajax({
            type:'post',
            url:'cart.php',
            data:{
              total_cart_items:"totalitems"
            },
            success:function(response) {
              //  if(response.length > 3){
              //   document.getElementById("total_items").textContent=0;
              // }
                document.getElementById("total_items").textContent=response;
              //console.log("total_cart_items : "+response);
            }
          });

      }

      //delete all items

      if( e.target.matches("#delete_all_btn")){
          $.ajax({
            type:'post',
            url:'cart.php',
            data:{
              delete_cart_items:"delete_all"
            },
            success:function(response) {
              //  if(response.length > 3){
              //   document.getElementById("total_items").textContent=0;
              // }
                document.getElementById("total_items").textContent=response;
                if(response == 0) mycart_list.innerHTML="Your cart is empty";
              //console.log("total_cart_items : "+response);
            }
          });

      }

      //order_btn
      if(e.target.matches("#order_btn")){
        $.ajax({
            type:'post',
            url:'cart.php',
            data:{
              make_order:"order"
            },
            success:function(response) {
              document.getElementById("total_items").textContent = response;
              if(response == 0){
                mycart_list.innerHTML = "<div class='alert alert-success' role='alert'> Order added successfuly, thank you! </div>";
              }
              else{
                mycart_list.innerHTML += "<div class='alert alert-danger' role='alert'> Order failed, try again! </div>";
              }
            }
          });
      }

    })

    
    /**

    The first function cart(id) when user clicks on any item this function calls gets the id of that item create a ajax request and send the data to store_items.php to store items.

The Second function show_cart() is used to display the cart whenever user clicks on a cart icon this function makes an ajax request and get the items user added in cart and then display all the items.

We also create an ajax request after page loading to get the total items in cart just to tell the user how many items he added in cart

**/
