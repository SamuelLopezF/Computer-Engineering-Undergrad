<?php require_once("PHP/Cart_Cookies/Cart_Cookie.php"); ?>
<?php require_once("PHP/Cart_Cookies/Cookie_Hash_Functions.php"); ?>
<?php session_start();
if(!empty($_SESSION["username_logged_in"])){$uid = $_SESSION["username_logged_in"];}
?>
<?php include "db_conn.php"; ?>
<?php include "comments_functions.php"; ?>
<!--
	Last Edited By: Sobhan
	Edit Date: 06-Nov-2020
	Edit Number: 5
	Edit Details:
		Cart
        CSS
-->
<!-- PHP -->
<?php
    if(isset($_COOKIE["cart_cookie"]))
        $menu = cookieToHash($_COOKIE["cart_cookie"]);
?>  
<!-- ========================= End of Important PHP ========================= -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Home | Dulceria China </title>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
    <meta name = "keywords" content = "dulceria china, restaurant, bakery, home, cantonese, baked goods, buns"/>
    <meta name = "description" content = "Dulceria China is home to some of the best baked Cantonese goods you'll find this side of town. Click to find out more!."/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href="Styles/template.css" rel="stylesheet">
    <style type = "text/CSS">
        .homeBar h1 {font-size: 3vw;}
        .homeBar img {
            width: 6vw;
            height: 6vw;
        }
        .homeBar {
            margin: auto;
        }
        .homeBar td * {
            text-align: center;
            vertical-align: center;
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        .homeBar td {
            text-align: center;
            vertical-align: center;
        }
        nav table {height: 6vw;}

        #carousel {
            height: 20vw;
            width: 30vw;
        }
    </style>
</head>
<body >
    <table class = "homeBar">
        <tr>
            <td><img width="100" src="Styles/BakeryLogo.png" alt="Dulceria China logo"> </td>
            <td><h1> Dulceria China</h1></td>
        </tr>
    </table>
        
    <header>
        <nav>
            <table>
                <tr>
                    <th class = "current_page"><a href = "index.php" class = "current_page"> Home </a></th>
                    <th><a href = "menu.php"> Menu </a></th>
                    <!-- <th><a href = "order.html"> Order </a></th> -->
                    <th><a href = "about_us.php"> About Us </a></th>
                    <th><a href = "contact_us.php"> Contact Us </a></th>
                    <?php if(!empty($_SESSION['login_status']) && $_SESSION['login_status'] == 'logged in')
                    {
                        echo "<th><a href = 'profile.php'> My Profile </a></th>";
                        echo "<th><a href = 'logout.php'> Log Out</a></th>";
                    }else{
                        echo '<th><a href = "account.php"> Log In </a></th>';
                        echo '<th><a href = "register.php"> Sign up </a></th>';
                    }
                    ?>
                    <th class="cart" id='cartIconTopRight'><a href="Cart.php"><span class="qty" id= 'cartIconTopRightQuantity'><?php if(isSet($menu)) cartSize($menu); else echo("0");?></span><img src="Styles/Cart.png" alt="Cart.html" width="40px" height="40px"/></a></th>
                </tr>
            </table>
        </nav>
    </header>
    
    <div class="row">
        <div class="col"><h3>Welcome to Dulceria China</h3>
            <p>
                Feel free to check out our menu with the description of our delicious food.
                We are exited to offer you a function of online order and delivery. 
                Also, create an account to order your reccuring product lists in one click!
            </p>
        </div>
    </div>

    <div class="special">
        <div class = "col">
            <h3>
                <script src="JavaScript/MonthSpecial1.js"></script>
            </h3>
            <p>
                <script>
		    document.write(text)
		</script>
            </p>
        </div>
        <div>
        <table>
            <tr>
                <td><button type = "button" id = "prev"> < </button></td>
                <td><div class = "small_brush"><img id = "carousel" src="Styles/Carousel/0.jpg" alt="Our Items" width = "480px" height = "320px" style="opacity: 1;"></div></td>
                <td><button type = "button" id = "next"> > </button></td>
            </tr>
        </table>
        <br/>
        </div>
    </div>


    <table class="comment_table">
        <tr>
            <td class="comment_input">
                <div class="not_banner comment_input">
                    <br/>
                    <?php
                        echo "<form method='POST' action='".setComment($connect)."'>
                        <h4>Leave a comment</h4>
                        <input type='hidden' name='username' value='".(!empty($uid)? $uid:"Anonymous")."' >
                        <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                        <textarea name='comment' rows='5' class='comment_textarea'></textarea>
                        <br/><br/>
                        <button type='submit' name='submit'>Comment</button>
                        </form><br/>";
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
            <div style="overflow-y: auto; height: 400px; width: 800px;" class="small_brush">
                <?php getComment($connect); ?>
            </div>
            </td>
        </tr>
        
    </table>

<footer>
    <table>
        <tr id = "email">
            <td><img src = "Styles/email.png" alt = "Email" width = "25px" height = "25px"/></td>
            <td><a href = "mailto:dulceriachina.ec@gmail.com">dulceriachina.ec@gmail.com</a></td>
        </tr>
        <tr id = "telephone">
            <td><img src = "Styles/phone.png" alt = "Phone" width = "25px" height = "25px"/></td>
            <td>(04) 251-0363 - (593) 997-045-024</td>
        </tr>
        <tr id = "facebook">
            <td><img src = "Styles/facebook.png" alt = "Facebook" width = "25px" height = "25px"/></td>
            <td><a href = "https://www.facebook.com/dulceriachina/" target = "_blank"> facebook.com/dulceriachina</a></td>
        </tr>
        <tr id = "instagram">
            <td><img src = "Styles/instagram.png" alt = "Instagram" width = "25px" height = "25px"/></td>
            <td><a href="https://www.instagram.com/dulceriachina/">@dulceriachina</a> </td>
        </tr>
    </table>
    <p> ©2020 Dulceria China </p>
</footer>
<script type = "text/JavaScript" src = "JavaScript/carousel.js"></script>
</body>
</html>
