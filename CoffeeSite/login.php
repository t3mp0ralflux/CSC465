<?php //This is the login page for registered users
//require 'includes/header.php';  moved down in the code to prevent output before session handling

if (isset($_POST['send'])) {
	$missing = array();
	$errors = array(); //contains additional user feedback regarding login
	$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
	if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL))  //Either empty or invalid email will be considered missing
		$missing[] = 'email';
		
	// Check for a password:
	if (empty($_POST['password']))
		$missing[]='password';
	else $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
	while (!$missing && !$errors){ 
		require_once ('../mysqli_config.php'); // Connect to the db. Adjust your path as needed
		// Make the query:
		$sql = "SELECT * FROM user WHERE emailAddr = '$email'";
		$result = mysqli_query($dbc, $sql);
		if(mysqli_num_rows($result)==1){ //email found
			$row = 	mysqli_fetch_array($result, MYSQLI_ASSOC);
			if ($password == password_verify($password, $row['password'])) { //passwords match
				$firstName = $row['firstName'];
				$lastName = $row['lastName'];
				$admin = $row['isAdmin'];
				$street = $row['street'];
				$city = $row['city'];
				$state = $row['state'];
				$zip = $row['zip'];
				$userId = $row['userId'];
				session_start();
				$_SESSION['firstName']=$firstName;
				$_SESSION['lastName']=$lastName;
				$_SESSION['email']=$email;
				$_SESSION['admin']=$admin;
				$_SESSION['street']=$street;
				$_SESSION['city']=$city;
				$_SESSION['state']=$state;
				$_SESSION['zip']=$zip;
				$_SESSION['userId']=$userId;
				$url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
				$url = rtrim($url, '/\\');
				$page = 'logged_in.php';
				$url .= '/' . $page;
				header("Location: $url");
				exit();
			}
			else {
				$errors[]='password';
			}
		}
		else //email not found
			$errors[]='email';
	}
}else{
	$missing = array();
	$errors = array();
}
require 'includes/header.php';
//console_log($errors);
?>

<div id="wrapper">
	<div id="banner"></div>
	<div>
		<?php 
		include('includes/nav.php');
		?>
	</div>
	<main>
		<?php if ($errors && in_array('email', $errors)) { ?>
				<span class="warning"><br>The email address you provided is not associated with an account<br>
				Please try another email address or <a href="Register.php">Register</a></span><br>
		<?php } ?>
		<?php if ($errors && in_array('password', $errors)) { ?>
					<span class="warning">The password supplied does not match the password for this email address. Please try again.</span><br>
		<?php } ?>
				
        <form method="post" action="login.php">
			<fieldset class="container">
				<legend>Registered Users Login</legend>
				<?php if ($missing || $errors) { ?>
				<p class="warning">Please fix the item(s) indicated.</p>
				<?php } ?>
			<?php if ($missing && in_array('email', $missing)) { ?>
				<p>
			<span class="warning">An email address is required</span>
			</p>
		<?php } ?>
            <p>
			<label for="email">Email address:</label>
                <input name="email" id="email" type="text"
				<?php if (isset($email)) {
                    echo 'value="'.$email.'"';
                } ?>>
			</p>
			<p></p>
			<?php if ($missing && in_array('password', $missing)) { ?>
				<p>		
				<span class="warning">Please enter a password</span>
				</p>
					<?php } ?>
					<p>
                <label for="pw">Password:</label>				
                <input name="password" id="pw" type="password">
            </p>
			<br>
            <p>
				
                <input name="send" type="submit" value="Login" id="login">
			</p>
			<br/>
				<label for="register">New to my shop?  <a href="Register.php">Register Here</a>
		</fieldset>
		</form>
	</main>
<?php include 'includes/footer.php'; ?>
</div>
