<?php require_once(__DIR__."/../PHP/Cart_Cookies/Cart_Cookie.php"); ?>
<?php require_once(__DIR__."/../PHP/Cart_Cookies/Cookie_Hash_Functions.php"); ?>
<?php session_start() ?>
<!--
	Last Edited By: Sobhan
	Edit Date: 26-Nov-2020
	Edit Number: 3
	Edit Details:
		Cart
-->
<!-- PHP -->
<?php
    if(isset($_COOKIE["cart_cookie"]))
        $menu = cookieToHash($_COOKIE["cart_cookie"]);
    if(isset($_POST["add_to_cart"])){
        $menu[$_POST["add_to_cart"]] += (int) $_POST["count"];
        hashToCookie($menu);
    }
?>  
<!-- ========================= End of Important PHP ========================= -->

<!DOCTYPE html>
<html lang = "en">
    <!-- Head -->
    <head>
        <title> Tan Wong Su | Dulceria China </title>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
	    <meta name = "keywords" content = "dulceria china, restaurant, bakery, tan wong su"/>
	    <meta name = "description" content = "Delicious tan wong su"/>
	    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
        <link type = "text/css" rel = "stylesheet" href = "../Styles/template.css"/>
        <style type = "text/css" rel = "stylesheet">
            .menuItem img {
                width: 50%;
                height: 50%;
            }
        </style>
    </head>
    <!-- Body -->
    <body>
        <!-- Header / Nav Bar-->
        <header>
            <nav>
                <table>
                    <tr>
                        <th class = "logo"> <a href = "../index.php" class = "logo"><img width="100" src="../Styles/BakeryLogo.png" alt="Dulceria China logo" class = "logo"/> </a></th>
                        <th><a href = "../index.php"> Home </a></th>
                        <th><a href = "../menu.php"> Menu </a></th>
                        <!-- <th><a href = "../order.html"> Order </a></th> -->
                        <th><a href = "../about_us.php"> About Us </a></th>
                        <th><a href = "../contact_us.php"> Contact Us </a></th>
                        <?php if(!empty($_SESSION['login_status']) && $_SESSION['login_status'] == 'logged in')
							{
								echo "<th><a href = '../profile.php'> My Profile </a></th>";
								echo "<th><a href = '../logout.php'> Log Out</a></th>";
							}else{
								echo '<th><a href = "../account.php"> Log In </a></th>';
								echo '<th><a href = "../register.php"> Sign up </a></th>';
							}
                        ?>        
                        <th class="cart" id='cartIconTopRight'><a href="../Cart.php"><span class="qty" id= 'cartIconTopRightQuantity'> <?php if(isSet($menu)) cartSize($menu); else echo("0");?> </span><img src="../Styles/Cart.png" alt="Cart.html" width="40px" height="40px"/></a></th>  
                    </tr>
                </table>
            </nav>
        </header> <br/>

        <!-- Picture -->
        <div class = "menuItem banner">
            <h3> Tan Wong Su </h3>
            <figure>
                <img src = "../Styles/Tan Wong.jpg" alt = "Tan Wong Su" class = "small_brush"/>
                <figcaption> Delicious Tan Wong Su! </figcaption>
            </figure>
            <form action = "" method = "POST">
                <table class = "menu_button">
                    <tr>
                        <td><label>Pieces (#)</label></td>
                        <td><label>Total Price ($)</label></td>   
                    </tr>
                    <tr>
                        <td><input type = "text" class = "input_pieces" name = "count"/></td>
                        <td><input type = "text" class = "input_price" name = "price"/></td>
                    </tr>
                    <tr>
                        <td colspan = "2"><button type = "submit" class = "add_btn" id = "tan_wong_su" name = "add_to_cart" value = "tan_wong_su">Add to Cart</button></td>
                    </tr>
                </table>
            </form>
            <br/>
        </div>
        
        <!-- Description -->
        <div class = "not_banner description">
            <h4> Description </h4>
            <p>
                Our tan won su is a great snack, and you're guaranteed to love it. Come down to our bakery to try one!
                They're only $1.00 each!
            </p>
        </div>

        <!-- Ingredients -->
        <div class = "banner ingredients">
            <h4> Ingredients </h4>
            <p>
                Our tan wong su contains wheat flour, eggs, water, dough conditioner, vegetable oil, sugar, vegetable shortening,
                red bean paste, and salted egg yolk.
            </p><br/>
        </div>
        <br/>

        <!-- Related Items -->
<div class="not_banner">
            <?php
            include '../db_conn.php';
            $sql = "SELECT * FROM products WHERE type='misc';";
            $result = mysqli_query($connect, $sql);
            ?>
            <h3>You may also like</h3>
            <table>
                <tbody>
                        <tr>
                        <?php
                            while ($row = mysqli_fetch_assoc($result)){
                                if($row['name'] !== 'Tan Wong Su'){
                            ?>
                            <td>
                            <h4><?php echo $row['name']; ?></h4>
                            <a href="<?php echo $row['url']; ?>">
                                <img src="../Styles/<?php echo $row['image']; ?>" alt="../<?php echo $row['image']; ?>" width="270px" height="210px" class="small_brush">
                            </a>
                            </td>
                            <?php
                                }
                            }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Footer -->
        <footer>
            <table>
                <tr id = "email">
                    <td><img src = "../Styles/email.png" alt = "Email" width = "25px" height = "25px"/></td>
                    <td><a href = "mailto:dulceriachina.ec@gmail.com">dulceriachina.ec@gmail.com</a></td>
                </tr>
                <tr id = "telephone">
                    <td><img src = "../Styles/phone.png" alt = "Phone" width = "25px" height = "25px"/></td>
                    <td>(04) 251-0363 - (593) 997-045-024</td>
                </tr>
                <tr id = "facebook">
                    <td><img src = "../Styles/facebook.png" alt = "Facebook" width = "25px" height = "25px"/></td>
                    <td><a href = "https://www.facebook.com/dulceriachina/" target = "_blank"> facebook.com/dulceriachina</a></td>
                </tr>
                <tr id = "instagram">
                    <td><img src = "../Styles/instagram.png" alt = "Instagram" width = "25px" height = "25px"/></td>
                    <td><a href="https://www.instagram.com/dulceriachina/">@dulceriachina</a> </td>
                </tr>
            </table>
            <p> ©2020 Dulceria China </p>
        </footer>

        <!-- Script(s) -->
        <script src = "../JavaScript/SingleMenuItems.js" type = "text/JavaScript"></script>

        <!-- <script src="../JavaScript/Menu.js"></script> -->

    </body>
</html>
