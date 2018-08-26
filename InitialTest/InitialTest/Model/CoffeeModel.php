<?php

/**
 * CoffeeModule short summary.
 * Insert, update, and delete DB info
 * CoffeeModule description.
 *
 * @version 1.0
 * @author Brent
 */

require("Entities/CoffeeEntity.php");

class CoffeeModel
{
    function GetCoffeeTypes(){
        require 'Credentials.php';

       $link = mysqli_connect($host, $user, $passwd) or die(mysqli_connect_error());
       $dbselected = mysqli_select_db($link, $database);
       $result = mysqli_query($link, "SELECT DISTINCT type FROM coffee") or die(mysqli_error($link));
       $types = array();

       while($row = mysqli_fetch_array($result)){
           array_push($types, $row[0]);
       }

       mysqli_close($link);
       return $types;

    }

    function GetCoffeeByType($type){
        require 'Credentials.php';

        $link = new mysqli($host, $username, $password, $dbname, $port) or die ('Could not connect to the database server' . mysqli_connect_error());
        $dbselected = mysqli_select_db($link, $database);

        $query = "SELECT * FROM coffee WHERE type like '$type'";
        $result = $link->query($query);
        
        $coffeeArray = array();

        while ($row = mysqli_fetch_array($result)){
            $name = $row[1];
            $type = $row[2];
            $price = $row[3];
            $roast = $row[4];
            $country = $row[5];
            $image = $row[6];
            $review = $row[7];
        }

        $coffee = new CoffeeEntity(-1, $name, $type, $price, $roast, $country, $image, $review);
        array_push($coffeeArray, $coffee);

        $link->close();
        return $coffeeArray;
    }
}

?>
