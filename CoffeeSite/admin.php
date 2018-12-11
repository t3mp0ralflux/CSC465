<?php 
include 'includes/header.php';
require_once ('../mysqli_config.php'); // Connect to the db. Adjust your path as needed

if(isset($_POST["userupdate"])){
    $missing = array();
    console_log("userupdate");
    if(empty($_POST['userid'])){
        $missing[] = 'id';
    }else{
        $userId = $_POST['userid'];
    }
    
    while(!$missing){
        $sql = "UPDATE user SET";
        $comma = " ";
        $whitelist = array('firstName','lastName','emailAddr','street','city','state','zip','isAdmin');

        foreach($_POST as $key => $val){
            if(!empty($val) && in_array($key, $whitelist)){
                $sql .= $comma . $key . " = '" . mysqli_real_escape_string($dbc,trim($val)) . "'";
                $comma = ", ";
            }
        }

        $sql .= " WHERE userId = '$userId'";
		// Make the query:
        $result = mysqli_query($dbc, $sql);
        //redirect back to admin to show updates
        $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
				$url = rtrim($url, '/\\');
				$page = 'admin.php';
				$url .= '/' . $page;
                header("Location: $url");
        $_POST = array();
        exit;
    }
}

if(isset($_POST["coffeeupdate"])){
    $missing = array();
    console_log("coffee update");
    if(empty($_POST['coffeeid'])){
        $missing[] = 'id';
    }else{
        $coffeeId = $_POST['coffeeid'];
    }
    while(!$missing){
        $sql = "UPDATE coffee SET";
        $comma = " ";
        $whitelist = array('name','type','price','roast','country','review');

        foreach($_POST as $key => $val){
            console_log("Key: ".$key);
            console_log("Value: ".$val);
            if(!empty($val) && in_array($key, $whitelist)){
                $sql .= $comma . $key . " = '" . mysqli_real_escape_string($dbc,trim($val)) . "'";
                $comma = ", ";
            }
        }

        $sql .= " WHERE id = '$coffeeId'";
		// Make the query:
        $result = mysqli_query($dbc, $sql);
        //redirect back to admin to show updates
        $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
				$url = rtrim($url, '/\\');
				$page = 'admin.php';
				$url .= '/' . $page;
                header("Location: $url");
        $_POST = array();
        exit;
    }
}

if (isset($_POST['picupload'])) {
    // Check for an uploaded file:
    if (isset($_FILES['upload'])) {
        // Validate the type. Should be GIF, JPEG or PNG.
        $allowed = array ('image/jpeg', 'image/png', 'image/gif');
        if (in_array($_FILES['upload']['type'], $allowed)) {
            // Validate the form info, then move the file over.
            $missing = array();
            if(isset($_POST['coffeeid'])){
                $id = $_POST['coffeeid'];
            }else{
                $missing[] = 'id';
            }
            if(isset($_POST['name'])){
                $name = $_POST['name'];
            }else{
                $missing[] = 'name';
            }
            if(isset($_POST['type'])){
                $coffeetype = $_POST['type'];
            }else{
                $missing[] = 'type';
            }
            if(isset($_POST['price'])){
                $price = $_POST['price'];
            }else{
                $missing[] = 'price';
            }
            if(isset($_POST['roast'])){
                $roast = $_POST['roast'];
            }else{
                $missing[] = 'roast';
            }
            if(isset($_POST['country'])){
                $country = $_POST['country'];
            }else{
                $missing[] = 'country';
            }
            if(isset($_POST['review'])){
                $review = $_POST['review'];
            }else{
                $missing[] = 'review';
            }

            if(empty($missing)){
                $image_path = $_FILES['upload']['tmp_name'];
                $image_name = $_FILES['upload']['name'];
                $image_info = getimagesize($image_path);
                if(!file_exists("Images/coffee/$image_name")){
                    $image = "Images/coffee/$image_name";
                    if (move_uploaded_file ($_FILES['upload']['tmp_name'], "Images/coffee/$image_name")) {  //start of move
                        $type=$_FILES['upload']['type'];
                        //write to database
                        //require_once ('../mysqli_config.php'); // Connect to the db.
                        $sql = "INSERT into coffee (id, name, type, price, roast, country, image, review) VALUES (?,?,?,?,?,?,?,?)";
                        $stmt = mysqli_prepare($dbc, $sql);
                        mysqli_stmt_bind_param($stmt, "issdssss", $id, $name, $coffeetype, $price, $roast, $country, $image, $review);
                        if (mysqli_stmt_execute($stmt)){
                            // $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
                            // $url = rtrim($url, '/\\');
                            // $page = 'admin.php';
                            // $url .= '/' . $page;
                            // header("Location: $url");
                            // $_POST = array();
                            // exit;
                        }else {
                            $errors = '<h2>We were unable to save your file data.</h2></main>';
                        }						
                        // Delete the file if it still exists:
                        if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name'])) {
                            unlink ($_FILES['upload']['tmp_name']);
                        }
                    } // End of move... IF.	
                    else {
                        $errors = '<h2>The file upload was unsuccessful.</h2>';
                        //echo '<h3>Please try again.</h3>';
                    }
                }else{
                    $errors = '<h2 class="warning">A file with that name already exists.</h2>';
                }
            }					
        } else { // Invalid type.
            $errors = '<h2 class="warning">Please upload a GIF, JPEG or PNG image.</h2>';
            }	
    } 	
}
?>
<body>
    <div id="wrapper">
         <div id="banner">
         </div>
    
        <?php 
        include('includes/nav.php')
        ?>
        <div>
            <fieldset>
            <legend>Manage Users</legend>
            <?php getUsers($dbc); ?>
            <br>
                <fieldset>
                <legend>Update User</legend>
                UserId is required for updates.  Add any other fields to update them.<br/><br>
                <?php if (isset($missing) && isset($_POST['userupdate'])) { ?>
                        <span class="warning">Have to have userId to update a record.</span><br>
                <?php } ?>
                <form enctype="multipart/form-data" action="admin.php" method="post">
                <table>
                    <tr id="cart_header">
                        <th class="left">UserId</th>
                        <th class="left">First Name</th>
                        <th class="left">Last Name</th>
                        <th class="left">email</th>
                        <th class="left">Street</th>
                    </tr>           
                    <tr>
                        <td><input name="userid" id="id" type="number"></td>
                        <td><input name="firstName" id="first" type="text"></td>
                        <td><input name="lastName" id="last" type="text"></td>
                        <td><input name="emailAddr" id="email" type="email"></td>
                        <td><input name="street" id="street" type="text"></td>
                    </tr>
                    <tr>
                        <th class="left">City</th>
                        <th class="left">State</th>
                        <th class="left">Zip</th>
                        <th class="left">Is Admin? (1=yes, 0=no)</th>
                    </tr>
                    <tr>
                        <td><input name="city" id="city" type="text"></td>
                        <td><input name="state" id="state" type="text"></td>
                        <td><input name="zip" id="zip" type="text"></td>
                        <td><input name="isAdmin" id="admin" type="number"></td>
                        <td><input name="userupdate" type="submit" id="update" value="Update"></td>
                    </tr>
                </table>
                </fieldset>
            </fieldset>
            </div>
            <br>
            <div>
            <fieldset>
            <legend>Manage Coffee</legend>
            <?php getCoffee($dbc); ?>
            <br>
                <fieldset>
                <legend>Update Coffee</legend>
                CoffeeId is required for updates.  Add any other fields to update them.<br/><br>
                <?php if (isset($missing) && isset($_POST['coffeeupdate'])) { ?>
                        <span class="warning">Have to have CoffeeID to update a record.</span><br>
                <?php } ?>
                <table>
                    <tr id="cart_header">
                        <th class="left">CoffeeId</th>
                        <th class="left">Name</th>
                        <th class="left">Type</th>
                        <th class="left">Price</th>
                    </tr>
                    <tr>
                        <td><input name="coffeeid" id="id" type="number"></td>
                        <td><input name="name" id="name" type="text"></td>
                        <td><input name="type" id="type" type="text"></td>
                        <td><input name="price" id ="price" type="number" step="0.01"></td>
                    </tr>
                    <tr>
                        <th class="left">Roast</th>
                        <th class="left">Country</th>
                        <th class="left">Review</th>
                    </tr>           
                    <tr>
                        <td><input name="roast" id="roast" type="text"></td>
                        <td><input name="country" id="country" type="text"></td>
                        <td><input name="review" id ="review" type="text"></td>
                        <td><input name="coffeeupdate" type="submit" id="update" value="Update"></td>
                    </tr>
                </table>
                </fieldset>
                <br>
            
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
            <fieldset>
                <legend>To add a Coffee, Fill out the above, Select a GIF, JPEG or PNG image of 2M or smaller to be uploaded:</legend>
                <label>
                    File:<input type="file" name="upload">
                </label>
                <label>And press
                    <input type="submit" name="picupload" value="Submit">
                </label>
                <?php if(isset($errors)){echo "$errors";}?>
            </fieldset>
        </fieldset>
        </form>
        </div>
        
            
        <?php 
        include('includes/footer.php')
        ?>
        
    </div>
</body>

<?php 
function getUsers($dbc){
    
    // Make the query:
    $sql = "SELECT userid,firstName,lastName,emailAddr,street,city,state,zip,datejoined,isadmin FROM user";
    $result = mysqli_query($dbc, $sql);
    //echo mysqli_num_rows($result);
    if(mysqli_num_rows($result)>0){ //query ran
        
        echo "<table>
            <tr id=\"cart_header\">
            <th class=\"left\">UserId</th>
            <th class=\"left\">First Name</th>
            <th class=\"left\">Last Name</th>
            <th class=\"left\">email</th>
            <th class=\"left\">Street</th>
            <th class=\"left\">City</th>
            <th class=\"left\">State</th>
            <th class=\"left\">Zip</th>
            <th class=\"left\">Date Joined</th>
            <th class=\"left\">Is Admin? (1=yes, 0=no)</th>
                        </tr>";
                        
        while($row = $result->fetch_assoc()){
            echo"<tr>";
            foreach($row as $value){
                echo "<td>$value</td>";
            } 
            echo"</tr>";
        }
        echo"</table>";
        
    }

}

function getCoffee($dbc){
    //require_once ('../mysqli_config.php'); // Connect to the db. Adjust your path as needed
    // Make the query:
    $sql = "SELECT id,name,type,price,roast,country,image,review FROM coffee";
    $result = mysqli_query($dbc, $sql);
    //echo mysqli_num_rows($result);
    if(mysqli_num_rows($result)>0){ //query ran
        
        echo "<table>
            <tr id=\"cart_header\">
            <th class=\"left\">CoffeeId</th>
            <th class=\"left\">Name</th>
            <th class=\"left\">Type</th>
            <th class=\"left\">Price</th>
            <th class=\"left\">Roast</th>
            <th class=\"left\">Country</th>
            <th class=\"left\">Pic Locale</th>
            <th class=\"left\">Review</th>
                        </tr>";
                        
        while($row = $result->fetch_assoc()){
            echo"<tr>";
            foreach($row as $value){
                echo "<td>$value</td>";
            } 
            echo"</tr>";
        }
        echo"</table>";
        
    }

}


?>