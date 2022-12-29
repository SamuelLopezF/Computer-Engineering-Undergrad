<?php
    // File Details: Provides functions that allow for cookie/hash conversion
    // Last Edited By: Sobhan
    // Edit Date: 29-Nov-2020
    // Edit Num: 2
    // Edit Details: Added increment and decrement cart, fixed a serious bug

    // Turns the cookie string into a hash
    function cookieToHash($string){
        if(isset($string)) {
            $temp = explode(" ", $string);
            $menu = array() ;
            for($i = 0; $i < sizeof($temp) - 1; $i = $i + 2){
               $menu["$temp[$i]"] = (int) $temp[$i+1];
           }
           return $menu; 
         } 
    }

    // Takes the current state of the hash and inserts it as a cookie string
    function hashToCookie($menu){
        $i = 0;
        $temp = array();
        foreach($menu as $name=>$count){
        $temp[$i++] = $name;
        $temp[$i++] = $count;
        }
        setcookie("cart_cookie",implode(" ", $temp), time() + 24*60*60, "/");
    }

    // turns the hash into a JavaScript hash
    function hashToJavaScript($menu){
        $output = "";
        foreach($menu as $key=>$value){
            $output += "$key: $value,";
        }
        $output[strlen($output)-1] = " ";
        $output = "let menu = {".$output."};";
        echo "<script type = 'test/JavaScript'> $output </script>";
    }

    function cartSize($menu){
        if(isset($menu)){
            $sum = 0;
            foreach($menu as $key=>$value)
                $sum += $value;
            echo $sum;
        }
        else
            echo "0";
    }

    function hashToString($hash){
        $i = 0;
        $temp = array();
        foreach($hash as $name=>$count){
        $temp[$i++] = $name;
        $temp[$i++] = $count;
        }
        return implode(" ", $temp);
    }

    function incrementCart(){
        if(isset($_COOKIE["cart_cookie"]) && isset($_POST["inc"])){
            $hash = cookieToHash($_COOKIE["cart_cookie"]);
            $hash[$_POST["inc"]] = $hash[$_POST["inc"]] + 1;
            hashToCookie($hash);
            $_COOKIE["cart_cookie"] = hashToString($hash);
        }
    }

    function decrementCart(){
        if(isset($_COOKIE["cart_cookie"]) && isset($_POST["dec"])){
            $hash = cookieToHash($_COOKIE["cart_cookie"]);
            $hash[$_POST["dec"]] = $hash[$_POST["dec"]] - 1;
            hashToCookie($hash);
            $_COOKIE["cart_cookie"] = hashToString($hash);
        }
    }


?>
