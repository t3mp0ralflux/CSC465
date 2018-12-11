<?php require 'includes/header.php'; ?>
<body>
	<div id="wrapper">
         <div id="banner">
         </div>
    
        <?php 
        include('includes/nav.php')
        ?>

		<main id="content_area">
    <h2>Your Cart</h2>
    <?php if (empty($_SESSION['cart']) || !isset($_SESSION['cart'])) { 
        echo '<h2>There are no products in your cart.</h2>';
		echo '<h3>Please use the Shop link above to shop.</h3>';
	} else {
		//display cart if not empty
		$total = 0; // Initialize cart total to recalculate according to current values. ?>
        <h4>To remove an item from your cart, change its quantity to 0.</h4>
		  <form action="cart.php" method="post">
            <input type="hidden" name="action" value="update">
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
				  <input type="number" class="cart_qty" name="newqty[<?php echo $img; ?>]" value="<?php echo $item['quantity'];?>">
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
			<tr>
				<td></td><td></td>
				<td><input type="submit" name="submit" value="Update My Cart"></td>
				<td></td>
			</tr>
		</table>
		</form>
		<br>
		<p><a href="cart.php?action=show_add_item">Add Item</a></p>
		<p><a href="cart.php?action=empty_cart">Empty Cart</a></p>
		<?php if (count($_SESSION['cart']) > 0) { ?>
			<h3> Proceed to: <a href="Checkout.php">Checkout</a> </h3>
		<?php } ?>			
    <?php } //end cart not empty ?>
		</main>

<?php include 'includes/footer.php'; ?>
		</body>
		