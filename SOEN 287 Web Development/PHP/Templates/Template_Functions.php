<?php

    $cart = [
        "almond_cookies",  0,
        "cheese_cake", 0,
        "chicken_biscuit", 0,
        "egg_tart", 0,
        "guava_bites", 0,
        "coconut_mochi", 0,
        "pineapple_bites", 0,
        "pineapple_cake", 0,
        "tan_wong_su", 0,
        "tau_sa_pen", 0,
        "pork_bun", 0,
        "red_bean_paste_bun", 0,
        "coconut_bun", 0,
        "custard_bun", 0,
    ];

    // Creates new file and creates 3 default templates
    function createFile($user){
        global $cart;
        // create file for appending
        $file = fopen("Database/users/$user.txt", "a");
        fwrite($file, "Template1 ".implode(" ", $cart)."\n");
        fwrite($file, "Template2 ".implode(" ", $cart)."\n");
        fwrite($file, "Template3 ".implode(" ", $cart)."\n");
        fflush($file);
        fclose($file);
    }
    // takes in a new template as $string and the $templateNumber (1 through 3) and updates it
    function updateTemplate($user, $string, $templateNumber){
        $fileName = "Database/users/$user.txt";
        $templateIndex = $templateNumber - 1;
        $file = file($fileName);
        $file[$templateIndex] = $string."\n"; // replace the line
        file_put_contents( $fileName , implode("", $file));
    }
    // Adds an order
    function addOrder($user, $order){
        $fileName = "../../Database/users/$user.txt";
        $file = fopen($fileName, "a");
        fwrite($file, date("d-m-Y")." $order\n");
        fflush($file);
        fclose($file);
    }

    // returns the template number (1 through 3) as a string
    function getTemplate($user, $templateNumber){
        $fileName = "Database/users/$user.txt";
        $templateIndex = $templateNumber - 1;
        $file = file($fileName);
        return $file[$templateIndex];
    }

    // Gets 5 most recent orders as an array of strings
    function getRecentOrders($user, $num = 5){
        $fileName = "Database/users/$user.txt";
        $file = file($fileName);
        $orders = array();
        for($i = sizeof($file)-1 ; $i > sizeof($file)-1 -$num ; $i--)
            // if this is a valid line and starts with a date
            if(isset($file[$i]) && preg_match("/\d{2}-\d{2}-\d{4}/", explode(" ", $file[$i])[0]))
                $orders[] = $file[$i];
        return $orders;
    }

    // takes a template string
    function templateStringToHTML($templateString, $templateNumber){
        $templateArray = explode(" ", $templateString);
        $title = $templateArray[0];
        $templateArray = array_slice($templateArray, 1);
        $row2 = "";
        $row3 = "";
        for($i = 0 ; $i < sizeof($templateArray) ; $i++){
            $row2 .= "<td>".ucwords(str_replace("_"," ",$templateArray[$i]))."</td>";
            $row3 .= "<td> <input type = 'text' class = 'quantity template' name = '".$templateArray[$i++]."' pattern = '[0-9]{1,2}' value = '".$templateArray[$i]."' required/> </td>";
        }
        $output =   "<tr class = 'templateRow'> <td>
                        <form action = '' method = 'POST'>
                            <table>
                                <tr> <td colspan = '".(sizeof($templateArray)/2)."'> <input type = 'text' name = 'template' value = '$title' pattern = '[A-Za-z0-9]{2,}' required/> </td> </tr>
                                <tr class = 'itemNames'> $row2 </tr>
                                <tr class = 'itemQuant'> $row3 </tr>
                                <tr> <td colspan = '".(sizeof($templateArray)/2)."'>
                                    <button type = 'submit' value = '$templateNumber' name = 'submit' id = 'submit'> Save </button>
                                    <button type = 'submit' value = '$templateNumber' name = 'checkout' id = 'checkout'> Checkout </button>
                                </td> </tr>
                            </table>
                        </form>
                    </td> </tr>";
        return $output;
    }

    // HTMLToTemplateString
    function HTMLToTemplateString(){
        if(!isset($_POST["submit"]))
            return;
        $tempArray = array();
        global $cart;
        // push all cart items to a hash
        for($i = 0; $i < sizeof($cart) - 1; $i = $i + 2)
            $tempArray[$cart[$i]] = $cart[$i+1];
        // if the post works, add the quantity of each item to the hash
        foreach($tempArray as $key=>$value)
            if(isset($_POST[$key]))
                $tempArray[$key] = $_POST[$key];

        $output = $_POST['template']." ";
        foreach($tempArray as $key => $value)
            $output .= "$key $value ";
        $output = rtrim($output);
        return $output;
    }

    // turns order into HTML
    function orderToHTML($orderAsString){
        $array = explode(" ", $orderAsString);
        $date = $array[0];
        $array = array_slice($array, 1);
        $row2 = "";
        $row3 = "";
        for($i = 0 ; $i < sizeof($array) ; $i++){
            $row2 .= "<td>".ucwords(str_replace("_"," ",$array[$i++]))."</td>";
            $row3 .= "<td>".$array[$i]."</td>";
        }
        $output =   "<tr class = 'orderRow'> <td>
                        <table>
                            <tr> <td colspan = '".(sizeof($array)/2)."'> Purchase Date: $date </td> </tr>
                            <tr class = 'itemNames'> $row2 </tr>
                            <tr class = 'itemQuant'> $row3 </tr>
                        </table>
                    </td> </tr>";
        return $output;

    }
    
    function templateToCart($user, $templateNumber){
        $templateString = getTemplate($user, $templateNumber);
        $tempArray = explode(" ", $templateString);
        $templateString = implode(" ", array_slice($tempArray,1));
        setcookie("cart_cookie", $templateString, time()+60*60*24, "/");
        $_COOKIE["cart_cookie"] = $templateString;
        // echo ($_COOKIE["cart_cookie"]);
        header("location: Cart.php");
    }
?>