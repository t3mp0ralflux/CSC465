<?php

require 'Controllers/CoffeeController.php';
$coffeeController = new CoffeeController();

if(isset($_POST['types'])){
    $coffeeTables = $coffeeController->CreateCoffeeTables($_POST['types']);
}else{
    $coffeeTables = $coffeeController->CreateCoffeeTables('%');
}

$title= 'Coffee Overview';
$content = $coffeeController->CreateCoffeeDropdownList(). $coffeeTables;

include 'Template.php';

?>