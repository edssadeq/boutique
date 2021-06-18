var mycart_list = document.getElementById("mycart_list");

$(document).ready(function(){
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
/*
    $(".btn_delete_item").on("click", function(){
      var item_index = $(this).attr("data-index");
      console.log("id :"+item_index);
      //var item_index = e.target.getAttribute("data-index");
      if(item_index>=0){
        $.ajax({
          type:'post',
          url:'cart.php',
          data:{
            delete_item:item_index
          },
          success:function(response) {
            mycart_list.innerHTML=response;
            //$("#mycart").slideToggle();
          }
       });
      }
    });
*/
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
      
    })
    /*
    function delete_item(e){
      //var item_index = $(this).attr("data-index");
      var item_index = e.target.getAttribute("data-index");
      if(item_index>0){
        $.ajax({
        type:'post',
        url:'cart.php',
        data:{
          delete_item:item_index
        },
        success:function(response) {
          mycart_list.innerHTML=response;
          //$("#mycart").slideToggle();
        }
       });
      }
    }
  */
    /**

    The first function cart(id) when user clicks on any item this function calls gets the id of that item create a ajax request and send the data to store_items.php to store items.

The Second function show_cart() is used to display the cart whenever user clicks on a cart icon this function makes an ajax request and get the items user added in cart and then display all the items.

We also create an ajax request after page loading to get the total items in cart just to tell the user how many items he added in cart

**/