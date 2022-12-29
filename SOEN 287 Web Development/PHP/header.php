<!-- 
    Connection to database
 -->

<?php

$dbServername = "localhost";
$dbUsername = "Bryan";
$dbPassword = "Eya3M4tmV2y2g0Ay";
$dbName = "bakery_db";

$connect = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset = "utf-8"/>

        <!--        STYLESHEETS         -->
        <!-- ************************** -->
        <link type = "text/css" rel = "stylesheet" href = "css/template.css"/>


        
    </head>
    <body>
        <header>
            <nav>
                <table>
                    <tr>
                        <th class="logo"><a href="home.php"><img width="100" src="Styles/BakeryLogo.png" alt="Dulceria China Logo"></a></th>
                        <th><a href = "home.php"> Home </a></th>
                        <th><a href = "menu.php"> Menu </a></th>
                        <th><a href = "order.php"> Order </a></th>
                        <th><a href = "about_us.php"> About Us </a></th>
                        <th><a href = "contact_us.php"> Contact Us </a></th>
                        <th><a href = "account.php"> Account </a></th>
                        <!-- Cart icon + number of items -->
                        <th class="cart" id='cartIconTopRight'><a href="cart.php">
                        <img src="Styles/Cart.png" alt="Cart icon" width="55px" height="55px">
                        <span class="qty" id= 'cartIconTopRightQuantity'>0</span></a></th>
                    </tr>
                </table>
            </nav>
        </header>