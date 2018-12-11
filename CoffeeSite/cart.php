<?php //The cart workings
	if(!isset($_SESSION)){
		session_start();
	} //to see if a cart has been started
	// Create a cart array if needed
	if (empty($_SESSION['cart'])) 
		$_SESSION['cart'] = array(); 

	// Determine the action to perform
	if (isset($_POST['action']))	//set if coming from product_details or cart_view: update 	
		$action = filter_var($_POST['action'], FILTER_SANITIZE_STRING);
	elseif (isset($_GET['action'])) //set if coming from cart_view "Add Item" or "Empty Cart" links
		$action = filter_var($_GET['action'], FILTER_SANITIZE_STRING );
	else //default
		$action = 'show_add_item';

	// Add or update cart as needed
	switch($action) {
		case 'add':
			$imgID = filter_var($_POST['image_id'], FILTER_SANITIZE_NUMBER_INT);
			if (isset($_SESSION['cart'][$imgID])) { //item already in cart
				$_SESSION['cart'][$imgID]['quantity'] ++ ; //update the quantity
			} else { // New product to the cart.
				//Filter the rest of the data:
				$imgTitle = filter_var($_POST['caption'], FILTER_SANITIZE_STRING );
				$imgPrice = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				// Add to the cart:
				$_SESSION['cart'][$imgID] = array ('caption'=> $imgTitle, 'quantity' => 1, 'price' => $imgPrice); 
			} // end of new product else
			include('cart_view.php');
			break;
		case 'update':
			$new_qty_list = filter_var_array($_POST['newqty'], FILTER_DEFAULT);
			foreach($new_qty_list as $img => $qty) {
				if ($_SESSION['cart'][$img]['quantity'] != $qty) {
					 $quantity = (int) $qty;
					if (isset($_SESSION['cart'][$img])) {
						if ($quantity <= 0) 
							unset($_SESSION['cart'][$img]);
						else
							$_SESSION['cart'][$img]['quantity'] = $quantity;
					}
				}
			}
			include('cart_view.php');
			break;
		case 'show_cart':
			include('cart_view.php');
			break;
		case 'show_add_item':
			include('Coffee.php');
			break;
		case 'empty_cart':
			$_SESSION['cart'] = [];
			include('cart_view.php');
			break;
	} //end switch
?>
