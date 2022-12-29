<!--
	Last Edited By: Bryan
	Edit Date: 24-Nov-2020
	Edit Number: 0
    Details:
        - Created the cart
        - Buttons to edit in cart (in progress)
        - Total calculation (in progress)
        - Created specific ccs stylesheet 'cart.css'
-->

<?php
    include 'header.php';
?>

    <!-- STYLESHEEETS -->
    <link rel="stylesheet" href="css/cart.css">


<?php
// COMMAND TO BE PASSED TO phpMyAdmin
$sql = "SELECT * FROM precheckout;";

// EXECUTES THE SQL STATEMENT IN phpMyAdmin
$result = mysqli_query($connect, "SELECT * FROM precheckout;");

// CHECKS IF WE HAVE ROWS IN THE DATABASE
$resultCheck = mysqli_num_rows($result);

?>



<div class = 'cart_container'>
<!--*******************************************
                CHECKOUT TABLE
    *******************************************-->
<title>Cart | Dulceria China</title>

    <table class="pre_checkout_table">
        <!-- TABLE HEAD -->
        <thead>
            <tr>
                <th><h2>QUANTITY</h2></th>
                <th colspan='2'><h2>PRODUCT</h2></th>
                <th colspan='2'><h2>PRICE</h2></th>

                <!-- REMOVE COMMENTS AND COMMENT ABOVE TO SEE LAYOUT -->

                <!-- <th><h1>QUANTITY</h1></th>
                <th><h1>IMAGE</h1></th>
                <th><h1>Name</h1></th>
                <th><h1>Price</h1></th>
                <th><h1>Actions</h1></th> -->

            </tr>
        </thead>

        <!-- TABLE BODY  -->
        <tbody>
        <?php

        if($resultCheck > 0){
            // IF WE HAVE ITEMS INSIDE 

                // $row IS An ARRAY CONTAINING THE ROWS FROM THE DATABASE AND THE INDEXES ARE THE HEADER NAMES
                while ($row = mysqli_fetch_assoc($result)){ 
                    // IF WE HAVE ITEMS, CREATE ROWS TO DISPLAY INFORMATION
                    print_r($row);  // TO SEE WHAT'S INSIDE OUR ARRAYS
                    echo '<br/>';
                    ?>
                    <tr>
                        <td class='quantity'><input type="number" value="<?php echo $row['quantity']; ?>"></td>
                        <td>
                            TEST IMAGE<br/><img src="<?php echo 'Styles/'.$row['image']; ?>" alt="test img">
                        </td>
                        <td><h4><?php echo $row['name']; ?></h4></td>
                        <td><h4>$<?php echo $row['price']; ?></h4></td>
                        <td>
                            <a href="#">UPDATE</a>
                            <br/>
                            <br/>
                            <a href="#"> REMOVE FROM CART</a>
                        </td>
                    </tr>
                <?php
                };
                ?>

                
                <!-- PRICE CALCULATION ROW -->
                <tr class='total'>
                    <td colspan='3'>TOTAL</td>
                    <td>$TOTAL PRICE</td>       
                    <td><a href="#">Proceed to Checkout</a></td>         
                </tr>  

                <?php
        }
        // IF CART IS EMPTY (precheckout_db is empty)
        else{
            echo '<h1> YOU HAVE NO ITEMS IN THE CART </h1>';
        }

        ?>
            
        </tbody>
    </table>
</div>















<?php
    include 'footer.php';
?>