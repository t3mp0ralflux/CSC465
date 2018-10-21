<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Simple HTML Form</title>
	<style type="text/css">
	label {
		font-weight: bold;
		color: #300ACC;
	}
	</style>
</head>
<body>
<!-- Script 2.1 - form.html -->
	<form action="handle_form.php" method="post">

		<fieldset><legend>Enter your information in the form below:</legend>

		<p><label>Name: <input type="text" name="name" size="20" maxlength="40"></label></p>

		<p><label>Email Address: <input type="email" name="email" size="40" maxlength="60"></label></p>

		<p><label for="gender">Gender: </label><input type="radio" name="gender" value="M"> Male <input type="radio" name="gender" value="F"> Female</p>

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

		<p><label>Comments: <textarea name="comments" rows="3" cols="40"></textarea></label></p>
		</fieldset>
		<p align="center"><input type="submit" name="submit" value="Submit My Information"></p>

	</form>

</body>
</html>