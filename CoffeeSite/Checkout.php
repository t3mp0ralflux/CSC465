<?php 
require 'includes/header.php'; 
?>
<body>
	<div id="wrapper">
         <div id="banner">
         </div>
    
        <?php 
        include('includes/nav.php')
        ?>
	<div class="checkout">
        <?php 

        if(isset($_POST['send'])){
            require_once ('../mysqli_config.php'); // Connect to the db. Adjust your path as needed
            // Make the query:
            $guid = rand(0,9999);
            $userId = $_SESSION['userId'];
            $sql = "Call addOrder('$userId','$guid')";
            mysqli_query($dbc,$sql);

            foreach($_SESSION['cart'] as $img => $item){
                $quantity = $item['quantity'];
                $sql = "Call addOrderDetails('$guid','$img','$quantity')";
                $result=mysqli_query($dbc, $sql);
            }
            
            echo "Your order has been placed.  Don't call us, we'll call you
            </div>";
            include 'includes/footer.php';
            echo"</div>";
            $_SESSION['cart'] = array();
            
        }else{

        if(!isset($_SESSION['email'])){
            echo"
            Please login / register before you checkout<br>
            <a href=\"login.php\">Login/Register</a>
            </div>";
            include 'includes/footer.php';
            echo"</div>";
        }else{
            $email = $_SESSION['email'];
            require_once ('../mysqli_config.php'); // Connect to the db. Adjust your path as needed
            // Make the query:
            $sql = "SELECT street, city, state, zip FROM user WHERE emailAddr = '$email'";
            $result = mysqli_query($dbc, $sql);
            if(mysqli_num_rows($result)==1){
                $row = 	mysqli_fetch_array($result, MYSQLI_ASSOC);
                $street = $row['street'];
                $city = $row['city'];
                $state = $row['state'];
                $zip = $row['zip'];
                $first = $_SESSION['firstName'];
                $last = $_SESSION['lastName'];
            } ?>
            
            <form action="cart.php" method="post">
            <?php $total = 0 ?>
            <table>
              <tr id="cart_header">
                <th class="left">Item</th>
                <th class="right">Price</th>
                <th class="right">Quantity</th>
                <th class="right">Total</th>
							</tr>
            <?php foreach($_SESSION['cart'] as $img => $item){	?>
			  <!--Print the row: -->
			  <tr>
				<td><?php echo $item['caption']; ?></td>
				<td class="right">$<?php echo $item['price']; ?></td>
				<td class="right">
				  <label type="number" class="cart_qty" name="newqty[<?php echo $img; ?>]"><?php echo $item['quantity'];?></label>
				</td>
				<?php 
				// Calculate the total and sub-totals.
				if (!isset ($item['quantity']))
					$item['quantity']=0;
				$subtotal = $item['quantity'] * $item['price'];
				$total += $subtotal;?>
				<td class="right">$<?php echo number_format($subtotal, 2); ?></td>
			  </tr>
		<?php 
		} // End of the foreach loop.?> 
		<!-- Print the total, close the table, and the form:-->
			<tr id="cart_footer">
				<td class="right" colspan="3"><strong>Total:</strong></td>
				<td class="right"><strong>$<?php echo number_format($total, 2);?></strong></td>
			</tr>
		</table>
		</form>
        </div>
            <aside id="sidebar">
                <fieldset>
                    <legend>Shipping Info</legend>
                <form method="post" action="Checkout.php">		
                <p>
                        <label for="first">First Name:</label> 
                        <input type="text" name="first" id="first" <?php if(isset($first)) echo " value=\"$first\"";?>>			
                        </p>

                        <p>
                        <label for="last">Last Name:</label> 
                        <input type="text" name="last" id="last"<?php if (isset($last)) echo " value=\"$last\"";?>>
                        </p>

                        <p>
                        <label for="email">Email:</label> 
                        <input type = "email" name="email" id="email"<?php if (isset($email)) echo " value=\"$email\"";?>> 
                        </p>

                        <p>
                        <label for="street">Street:</label>
                        <input type = "text" name="street" id="street" <?php if (isset($street)) echo " value=\"$street\"";?>> 
                        </p>

                        <p>
                        <label for="city">City:</label> 
                        <input type = "text" name="city" id="city" <?php if (isset($city)) echo " value=\"$city\"";?>> 
                        </p>

                        <p>
                        <label for="state">State:</label>
                        <input type = "text" name="state" id="state" <?php if (isset($state)) echo " value=\"$state\"";?>>
                        </p>

                        <p>
                        <label for="zip">Zip Code: </label>
                        <input type = "text" name="zip" id="zip" <?php if (isset($zip)) echo " value=\"$zip\"";?>> 
                        </p>

                        <br>
                        <p>
                        <label></label>
                        <input name="send" type="submit" value="Place Order" id="order"> 
                        </p>
                </form>
            </fieldset>
            </aside>
            <?php include 'includes/footer.php'; ?>
            <?php  }?>
        <?php }?>

</div>
</body>