<?php
	ini_set('error_reporting', 1);
	//require_once '../../mysqli_config.php';  //$dbc is the connection string set upon successful connection
		$missing = array();	
		if(isset($_POST['submit'])) {
			if (!empty($_POST['first']))
				$first = $_POST['first'];
			else
				$missing[]= "first";
		
			if (!empty($_POST['last']))
				$last = $_POST['last'];
			else
				$missing['last'] = "Last name is missing<br>";
			
			if (!empty($_POST['email']))
				$email = $_POST['email'];
			else
				$missing[] = "Email is missing<br>";
			
				if (!empty($_POST['street']))
				$street = $_POST['street'];
			else
				$missing[] = "street";

				if (!empty($_POST['city']))
				$city = $_POST['city'];
			else
				$missing[] = "city";

				if (!empty($_POST['state']))
				$state = $_POST['state'];
			else
				$missing[] = "state";

				if (!empty($_POST['zip']))
				$zip = $_POST['zip'];
			else
				$missing[] = "zip";

			if (!empty($_POST['pwd']))
				$pwd = $_POST['pwd'];
			else
				$missing[] = "password";	
			
			if (!empty($_POST['conf']))
				$conf = $_POST['conf'];
			else
				$missing[] = "confirmation";	
			
			if ($pwd != $conf) {
				$missing[] = "mismatched";
				$message = "The passwords don't match<br>";
			}
			if (empty($missing)){
				require_once '../mysqli_config.php';  //$dbc is the connection string set upon successful connection
				require 'includes/header.php';			
				echo "<div id=\"wrapper\">
						<div id=\"banner\">
						</div>
						<div>";
						include('includes/nav.php');
				echo "</div>
					<main id=\"content_area\">";
				$checkQuery = "SELECT * from user where emailAddr = '$email'";
				$checkresult = mysqli_query($dbc, $checkQuery);
				$rows = $checkresult->num_rows;
				 if($rows > 0){
				 	echo "You've already registered, please login with your credentials.<br>";
					 echo "</main>";
					 echo "</body>";
				 	include 'includes/footer.php';
					exit;
				}else{
					$pwd = password_hash($pwd, PASSWORD_DEFAULT);
					$email = filter_var($email, FILTER_VALIDATE_EMAIL);
					$street = filter_var($street, FILTER_SANITIZE_STRING);
					$city = filter_var($city, FILTER_SANITIZE_STRING);
					$state= filter_var($state, FILTER_SANITIZE_STRING);
					$zip = filter_var($zip, FILTER_SANITIZE_NUMBER_INT);
					$query="Call addUser('$first', '$last', '$email','$street','$city','$state','$zip','$pwd')";
					$result = mysqli_query($dbc, $query);
					if($result) { //It worked
						echo "Thanks for registering $first $last<br>";
						echo htmlspecialchars("We will send a confirmation email to $email");
						echo "<br>Click the Shop link at the top to start shopping!";
					}
					else echo "We're sorry, we were not able to add you at this time.<br>";
					echo "</main>";
					echo "</body>";
					include 'includes/footer.php';
					exit;
				}
			}		
	}
?>
<?php 
include 'includes/header.php';	
?>
<body>
	<div id="wrapper">
			<div id="banner">
			</div>

		<?php 
		include('includes/nav.php')
		?>
	<main>
		<form method="post" action="Register.php" class="forms">
			<fieldset>
				<?php if ($missing)
					echo "There were some problems. Please try again:<br>";
				?>
				<legend>Create Your Account with Us!</legend>
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

				<p>
				<!-- Inform the user if the passwords don't match but never make them sticky -->
				<?php if(isset($message)) echo "$message<br>"; ?>
				<label for="pwd">Password:</label>
				<input type = "password" name="pwd" id="pwd"> 
				</p>

				<p>
				<label for="conf">Confirm Password:</label>
				<input type = "password" name = "conf" id="conf">
				</p>

				<br/>
				<input type = submit value = "Register" name="submit">
				<br/>
			</fieldset>
		</form>
	</main>
	<?php include 'includes/footer.php'; ?>
	</div>
</body>


