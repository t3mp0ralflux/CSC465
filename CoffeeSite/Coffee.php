<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php

require('includes/CoffeeModel.php');


if(isset($_POST['types'])){
    $coffeeTables = CreateCoffeeTables($_POST['types']);
}else{
    $coffeeTables = CreateCoffeeTables('%');
}

$content = CreateCoffeeDropdownList().$coffeeTables;

function CreateCoffeeDropdownList(){
    
    $coffeeModel = new CoffeeModel();
    $result = "<form action = '' method = 'post' width = '200px'>
                Please select a type:
               <select name = 'types'>
                    <option value = '%' > All </option>
                    ".CreateOptionValues($coffeeModel->GetCoffeeTypes()).
                    "</select>
                    <input type = 'submit' value = 'Search' />
               </form>";
    return $result;
}

function CreateOptionValues(array $valueArray){

    $result = "";

    foreach($valueArray as $value){
        $result = $result . "<option value = '$value'>$value</option>";
    }

    return $result;

}

function CreateCoffeeTables($types){

    $coffeeModel = new CoffeeModel();
    $coffeeArray = $coffeeModel->GetCoffeeByType($types);
    $result = "";

    foreach ($coffeeArray as $key => $coffee){
        $result = $result . "<table class = 'coffeeTable'>
                                <tr>
                                    <th rowspan='6' width='150px'><img runat = 'server' src= '$coffee->image' /></th>
                                    <th width='75px'>Name: </th>
                                    <td>$coffee->name</td>
                                </tr>

                                <tr>
                                    <th>Type: </th>
                                    <td>$coffee->type</td>
                                </tr>

                                <tr>
                                    <th>Price:</th>
                                    <td>$coffee->price</td>
                                </tr>

                                <tr>
                                    <th>Roast: </th>
                                    <td>$coffee->roast</td>
                                </tr>

                                <tr>
                                    <th>Origin: </th>
                                    <td>$coffee->country</td>
                                </tr>

                                <tr>
                                    <td colspan='2'>$coffee->review</td>
                                </tr>
                                <tr>
                                <td>
                                    <form style=\"display:inline;\" action=\"cart.php?action=add\" method=\"post\">
                                        <input type=\"hidden\" name=\"action\" value=\"add\">
                                        <input type=\"hidden\" name=\"image_id\" value=\"<?php echo $coffee->id; ?>\">
                                        <input type=\"hidden\" name=\"price\" value=\"<?php echo $coffee->price; ?>\">
                                        <input type=\"hidden\" name=\"caption\" value=\"$coffee->name\">
                                        <input type=\"hidden\" name=\"qty\" value = 1>
                                        <input type=\"submit\" value=\"Add to Cart\">
                                    </form>
                                </td>
                                </tr>
                            </table>
                            ";
    }

    return $result;

}
echo "<title>Coffee Overview</title>";
include('includes/header.php');
?>
<body>
    <div id="wrapper">
        <div id="banner"></div>
        <div>
            <?php 
            include('includes/nav.php');
            ?>
        </div>
        <div id="content_area">
            <?php 
            echo $content;
            ?>
        </div>

        <?php 
        include('includes/footer.php')
        ?>
    </div>
</body>