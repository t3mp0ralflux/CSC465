<?php

/**
 * CoffeeModule short summary.
 * Insert, update, and delete DB info
 * CoffeeModule description.
 *
 * @version 1.0
 * @author Brent
 */

require("includes/CoffeeEntity.php");

class CoffeeModel
{
    
    function GetCoffeeTypes(){        
        require '../mysqli_config.php';
    //    $link = mysqli_connect($host, $username, $password, $dbname, $port) or die(mysqli_connect_error());
       $result = mysqli_query($dbc, "SELECT DISTINCT type FROM coffee") or die(mysqli_error($dbc));
       $types = array();

       while($row = mysqli_fetch_array($result)){
           array_push($types, $row[0]);
       }

       mysqli_close($dbc);
       return $types;

    }

    function GetCoffeeByType($type){
        require '../mysqli_config.php';

        // $link = new mysqli($host, $username, $password, $dbname, $port) or die ('Could not connect to the database server' . mysqli_connect_error());
        $query = "SELECT * FROM coffee WHERE type like '$type'";
        $result = mysqli_query($dbc, $query);
        
        $coffeeArray = array();
        

        while ($row = mysqli_fetch_array($result)){
            $id = $row[0];
            $name = $row[1];
            $type = $row[2];
            $price = $row[3];
            $roast = $row[4];
            $country = $row[5];
            $image = $row[6];
            $review = $row[7];

            $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);
            array_push($coffeeArray, $coffee);
        }

        $dbc->close();
        return $coffeeArray;
    }
}

?>
