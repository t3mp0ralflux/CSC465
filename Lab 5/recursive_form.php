<?php include('includes/header.php'); ?>

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
		$age = date("Y") - $_POST['yearofbirth'];
		if ($age < 30)
			$age_range = 'under 30';
		elseif ($age > 30 and $age < 60)
			$age_range = 'between 30 and 60';
		else $age_range = 'over 60';

		if (isset($missing)) { //There is at least one element in the $missing array
			echo 'You forgot the following form item(s):<br>';
			
			foreach($missing as $value){
				echo "<font color='red'>-$value</font><br>";
			}
		}else{ 	//Form was filled out completely and submitted. Print the submitted information:
            echo "<p>Thank you, $name, for the following comments:<br>";
            echo "<pre>\"$comments\"</pre>"; //HTML pre is preformatted text. We are assuming the comment is non-malicious
            echo "<p>We will reply to you at $email</p>";
			echo "You entered <strong>$age_range</strong> for your age, and <strong>$gender</strong> for your gender<br>";
			include('includes/footer.php');
            exit;
        }
	}
    
    ?>
    <form action="recursive_form.php" method="post">

		<fieldset><legend>Enter your information in the form below:</legend>

		<p><label>Name: <input type="text" name="name" size="20" maxlength="40" <?php if (isset($name)) echo "value=\"$name\"";?>></label></p>

		<p><label>Email Address: <input type="email" name="email" size="40" maxlength="60" <?php if (isset($email)) echo "value=\"$email\"";?>></label></p>

		<p><label for="gender">Gender: </label><input type="radio" name="gender" value="M" <?php if (isset($gender) && $gender === 'M') echo " checked";?>> Male <input type="radio" name="gender" value="F" <?php if (isset($gender) && $gender === 'F') echo " checked";?>> Female</p>

		<p><label>Year of Birth:
			<select name="yearofbirth">
				<?php 
				define('START', 1920);
				define('END', 2020);
				foreach(range(START, END) as $number){
					if($number == floor(count(range(START, END))/2)+START){
						echo '<option selected value =' .$number.'>'.$number.'</option>';
					}else{
						echo '<option value =' .$number.'>'.$number.'</option>';
					}
				} 
				?>
			</select>
		</label></p>

		<p><label>Comments: <textarea name="comments" rows="3" cols="40"><?php if (isset($comments)) echo "$comments";?></textarea></label></p>
		</fieldset>
		<p align="center"><input type="submit" name="submit" value="Submit My Information"></p>

	</form>
<?php include('includes/footer.php'); ?>