<?php
    // Last Edited By: Sobhan
    // Edit Number: 3
    // Edit Date: 06-Dec-2020
    // Edit Details: Formatting

    $dataBase = "Database/Item_Info.txt";

    function createRow($itemID, $itemCount){
        // find price
        $price = getPrice($itemID);
        if(!isset($price))
            return null;
        // find total cost
        $total = (float)$price*(int)$itemCount;
        // format name
        $name = ucwords(str_replace("_"," ",$itemID));
        // print row
        echo("<tr class = 'cartRow'>
                <td style = 'width: 25%;'> $name </td>
                <td style = 'width: 15%; text-align: right;'> <button name = 'dec' value = '$itemID' type = 'submit'> < </button> </td>
                <td style = 'width: 20%;'> $itemCount </td>
                <td style = 'width: 15%; text-align: left;'> <button name = 'inc' value = '$itemID' type = 'submit'> > </button> </td>
                <td style = 'width: 25%;'> $".number_format($total,2)." </td>
            </tr>");
    }

    function getPrice($item){
        global $dataBase;
        if(file_exists($dataBase) && is_readable($dataBase)){
            // open file
            $list = file($dataBase);
            // get each line and check the id. Return if it matches
            foreach ($list as $food){
                $id = explode(" ", $food)[0];
                $price = explode(" ", $food)[1];
                if($item == $id)
                    return $price;
            } 
            return null;
        }
        else{
            return null;
        }
    }

    function createString($itemID, $itemCount){
        // find price
        $price = getPrice($itemID);
        if(!isset($price))
            return null;
        // find total cost
        $total = (float)$price*(int)$itemCount;
        // format name
        $name = ucwords(str_replace("_"," ",$itemID));
        // print row
        return "<p>$name : $itemCount : $$total<p>";
    }

    function calculatePrice($itemID, $itemCount){
        // find price
        $price = getPrice($itemID);
        if(!isset($price))
            return null;
        // find total cost
        $total = (float)$price*(int)$itemCount;
        return (float) $total;
    }


?>
