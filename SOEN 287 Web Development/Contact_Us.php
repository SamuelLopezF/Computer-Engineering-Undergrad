<?php require_once("PHP/Cart_Cookies/Cart_Cookie.php"); ?>
<?php require_once("PHP/Cart_Cookies/Cookie_Hash_Functions.php"); ?>
<?php session_start() ?>
<?php
    if(isset($_COOKIE["cart_cookie"]))
        $menu = cookieToHash($_COOKIE["cart_cookie"]);
?>  
<!-- ========================= End of Important PHP ========================= -->
<!DOCTYPE html>
<html lang = "en">
    <head>
        <title> Contact Us | Dulceria China </title>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
	    <meta name = "keywords" content = "dulceria china, restaurant, bakery, home, cantonese, baked goods, buns, contact us, contact information"/>
	    <meta name = "description" content = "If you have any concerns or want to discuss something, feel free to contact us!"/>
	    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
		<link href="Styles/template.css" rel="stylesheet">
		<title> a2q3 </title>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
		integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" 
		crossorigin=""/>
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
		integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" 
		crossorigin=""></script>
        <script src ="JavaScript/map.js" type ="text/javascript" defer></script>
        <style type = "text/CSS">
            #contact_info * {line-height: 6px;}
        </style>
        
        
    </head>

    <body>
		<header>
            <nav>
                <table>
                    <tr>
                        <th class = "logo"> <a href = "index.php" class = "logo"><img width="100" src="Styles/BakeryLogo.png" alt="Dulceria China logo" class = "logo"/> </a></th>
                        <th><a href = "index.php"> Home </a></th>
                        <th><a href = "menu.php"> Menu </a></th>
                        <!-- <th><a href = "order.html"> Order </a></th> -->
                        <th><a href = "about_us.php"> About Us </a></th>
                        <th class = "current_page"><a href = "contact_us.php" class = "current_page"> Contact Us </a></th>
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


		
        <table id = "contact_us">
            <tr>
            <td id = "contact_info">
                    <h4>Contact Information:</h4>
                    <p>Tel: (04) 251-0363</p>
                    <p>Tel: (593) 997-045-024 </p>
                    <p>dulceriachina.ec@gmail.com</p>

            </td>
            <td rowspan = "2">
            <form class = "message small_brush" action = "Mail/PHPMailerTemplate/contactMail.php" method = "POST">
                <h4> Send us a message now!</h4>
                <table>
                    <tr>
                        <td>First Name *</td>
                        <td>Last Name *</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="fname" name="fname" placeholder="First name" required></td>
                        <td><input type="text" id="lname" name="lname" placeholder="Last name" required></td>
                    </tr>
                    <tr><td colspan = "2">Email Address *</td></tr>
                    <tr><td colspan = "2"><input type="email" id="email" name="email" placeholder="sample@email.com" required></td></tr>
                    <tr>
                        <td colspan = "2">Phone Number *</td>
                    </tr>
                    <tr>
                        <td colspan = "2">
                            <input type="text" id="subject" name="subject" placeholder="123-456-7890" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "2">Message</td>
                    </tr>
                    <tr>
                        <td colspan = "2">
                            <textarea  id="sr" name="sr" cols="60" required>Please specify any special request you might have.</textarea>
                        </td>
                    </tr>
                    <tr id = "submit">
                        <td colspan = "2">
                            <button type = "submit" name = "submit" value = "submit" >Submit</button>
                        </td>
                    </tr>
                </table>
            </form>
            </td>
            </tr>
            <td id = "my_map">
                <div id="mapid"></div>
                    <!--
                    <fieldset>//dont know the address&cant find Dulcería China on google map so kept the one for concordia. please change
                        <legend>Search Address</legend>
                        <input type="text" id="searchAddress" name="searchAddress" placeholder="searchAddress">
                        <input type="submit" value="Submit" id="submit"  class="w3-btn w3-round-xxlarge"><br><br>
                        <p>Your distance from Dulceria China is <b><span style="color:red;" id="distance"></span></b> km</p>	
                    </fieldset>
                    -->
            </td>
        </table>
                    


    
		
		<footer>
            <table>
                <tr id = "email">
                    <td>
                        <img src = "Styles/email.png" alt = "Email" width = "25px" height = "25px"/>
                    </td>
                    <td>
                        <a href = "mailto:dulceriachina.ec@gmail.com">dulceriachina.ec@gmail.com</a>
                    </td>
    
                </tr>
                <tr id = "telephone">
                    <td>
                        <img src = "Styles/phone.png" alt = "Phone" width = "25px" height = "25px"/>
                    </td>
                    <td>
                        (04) 251-0363 - (593) 997-045-024
                    </td>
    
                </tr>
                <tr id = "facebook">
                    <td>
                        <img src = "Styles/facebook.png" alt = "Facebook" width = "25px" height = "25px"/>
                    </td>
                    <td>
                        <a href = "https://www.facebook.com/dulceriachina/" target = "_blank"> facebook.com/dulceriachina</a>
                    </td>
    
                </tr>
                <tr id = "instagram">
                    <td>
                        <img src = "Styles/instagram.png" alt = "Instagram" width = "25px" height = "25px"/>
                    </td>
                    <td>
                       <a href="https://www.instagram.com/dulceriachina/">@dulceriachina</a> 
                    </td>
    
                </tr>
            </table>
            <p> ©2020 Dulceria China </p>
        </footer>
        
        	<script src="JavaScript/index.js"></script>
	</body>
</html>
<!--var dulceriaLat = -2.195611;
			var dulceriaLong = -79.884254;-->
