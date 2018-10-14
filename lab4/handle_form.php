<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Form Feedback</title>
</head>
<body>
<?php
	if (isset($_POST['submit'])) {
	
		// Create scalar variables for the form data:
		if (!empty($_POST['name']))
			$name = $_POST['name'];
		else
			$missing[] = "name";
		
		if (!empty($_POST['email']))
			$email = $_POST['email'];
		else
			$missing[] = "email";		
		
		if (!empty($_POST['comments']))
			$comments = $_POST['comments'];
		else
			$missing[] = "comments";
		
		if (isset($_POST['gender']))
			$gender = $_POST['gender'];
		else
			$missing[] = "gender";
		
		//The first option of a select list is the default, so there will always be something set
		if ($_POST['yearofbirth'] != "default") {
			$age = date("Y") - $_POST['yearofbirth'];
			if ($age < 30)
				$age_range = 'under 30';
			elseif ($age > 30 and $age < 60)
				$age_range = 'between 30 and 60';
			else $age_range = 'over 60';
		}
		else
			$missing[] = "age";

		if (isset($missing)) { //There is at least one element in the $missing array
			echo 'You forgot the following form item(s):<br>';
			
			foreach($missing as $value){
				echo "-$value<br>";
			}		
			echo 'Please <a href="form.htm">return to the form<a>';
			exit;
		}
	}
	else { //form was not submitted to reach this page
		echo 'You have reached this page in error.<br>Our form is <a href="form.htm">here<a>';
		exit;
	}
	//Form was filled out completely and submitted. Print the submitted information:
	echo "<p>Thank you, $name, for the following comments:<br>";
	echo "<pre>\"$comments\"</pre>"; //HTML pre is preformatted text. We are assuming the comment is non-malicious
	echo "<p>We will reply to you at $email</p>";
	echo "You entered <strong>$age_range</strong> for your age, and <strong>$gender</strong> for your gender<br>";
	echo 'If anything is incorrect, please <a href="form.htm">return to our form</a>';
	?>
</body>
</html>