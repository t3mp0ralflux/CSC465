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
	<main id ="content_area">
	<?php 
	header("refresh:5;url=index.php");
	if (isset($_SESSION['email'])) {
			$firstname = $_SESSION['firstName'];
			$message = "Welcome back $firstname";
			$message2 = "You are now logged in";
			$message3 = "You will be redirected to the main page in 5 seconds.";
			$message4 = 'If not, <a href="index.php">Click here</a>';
		} else { 
			$message = 'You have reached this page in error';
			$message2 = 'Please use the menu above';	
		}
		// Print the message:
		echo '<h2>'.$message.'</h2>';
		echo '<h3>'.$message2.'</h3>';
		echo '<h3>'.$message3.'</h3>';
		echo '<h3>'.$message4.'</h3>';
		?>
	</main>
	<?php // Include the footer and quit the script:
	include ('includes/footer.php'); 
	?>
	</div>
</body>
	