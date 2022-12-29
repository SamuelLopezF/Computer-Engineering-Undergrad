<!--
	Last Edited By: Sobhan
	Edit Date: 23-Nov-2020
	Edit Number: 1
	Edit Details:
        Created Page
        
    Last Edited By: Bryan
	Edit Date: 
	Edit Number: 1
    Edit Details:
        Changed the extension to .php
        See (REMOVED)/(NEW) elements

-->

<!-- (NEW) Header -->
<?php
    include ('header.php');
?>

<title>Almond Cookies</title>
    <!-- Head   (REMOVED) -->

    <!-- Body -->
    <body>
        <!-- Header / Nav Bar   (REMOVED)-->
        
        <!-- Picture -->
        <div class = "menuItem banner">
            <h3> Almond Cookies </h3>
            <figure>
                <img src = "Styles/Almond cookies.jpg" alt = "Almond Cookies" class = "small_brush"/>
                <figcaption> Delicious Almond Cookies! </figcaption>
            </figure>
            <form action = "">
                <table class = "menu_button">
                    <tr>
                        <td><label>Pieces (#)</label></td>
                        <td><label>Total Price ($)</label></td>   
                    </tr>
                    <tr>
                        <td><input type = "text" class = "input_pieces"/></td>
                        <td><input type = "text" class = "input_price"/></td>
                    </tr>
                    <tr>
                        <td colspan = "2"><button type = "button" class = "add_btn" id = "almond_cookies">Add to Cart</button></td>
                    </tr>
                </table>
            </form>
            <br/>
        </div>
        
        <!-- Description -->
        <div class = "not_banner description">
            <h4> Description </h4>
            <p>
                These are some of the best almond cookies you'll find this side of town. Like all our products, these cookies are made with love and dedication.
                They're so delicious that we know you'll be back for more. The best part is that they're only $0.50 each!
            </p>
        </div>

        <!-- Ingredients -->
        <div class = "banner ingredients">
            <h4> Ingredients </h4>
            <p>
                Our almond cookies contain wheat flour, eggs, lard, sugar, and almonds.
            </p><br/>
        </div>
        <br/>
        
        <!-- Footer (REMOVED) -->

        <!-- Script(s) -->
        <script src = "../JavaScript/SingleMenuItems.js" type = "text/JavaScript"></script>

        <!-- <script src="../JavaScript/Menu.js"></script> -->

<!-- Footer (NEW) -->
<?php
    include ('footer.php');
?>
