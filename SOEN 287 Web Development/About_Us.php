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
        <title> About Us | Dulceria China </title>
		<meta charset = "utf-8"/> 
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
		<meta name = "keywords" content = "dulceria china, restaurant, bakery, home, cantonese, baked goods, buns, about us, learn more, background"/>
		<meta name = "description" content = "Want to know more about how we came to be? Check out our About Us page to find out Dulceria China's origin story!"/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<link href="Styles/template.css" rel="stylesheet">
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
                        <th class = "current_page"><a href = "about_us.php" class = "current_page"> About Us </a></th>
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

		<h1> About Us </h1>
		
		<table class = "about_table">
			<tr class = "alt_row">
				<td>
					<h3> Our Food </h3>
					<p>
						Our food is based on traditional Cantonese Dim Sum and have fused some of the products with local cuisine.

					</p>
				</td>
				<td>
					<img src="Styles/food.jpg" alt="food placeholder" width="600" height="300" class = "brush">
				</td>
			</tr>
			<tr>
				<td>
					<img src="Styles/History.jpg" alt="history placeholder" width="600" height="300" class = "brush">
				</td>	
				<td>
					<h3> Our History </h3>
					<p>
						We are a small bakery located in the downtown of Guayaquil city. We opened our doors in 2015. 
						Before we started this business we had a restaurant. There were many other restaurants in the area 
						so there was a lot of competition. We were already selling steamed buns and red bean paste pastries so we thought 
						of opening a business focused on that.
					</p>
				</td>
			</tr>
			<!-- <tr class = "alt_row">
				<td>
					<h3> Our Team </h3>
					<p> Random Cooks description I C&P from the internet<br>
						Cooks often think only of the team in the kitchen. The kitchen staff members may think of themselves as a team (“us”) allied against the front of house staff (“them”). 
						The kitchen staff on other shifts, management, and other components of the operation may also be considered “them.” This is not productive in a well-functioning restaurant. 
						The staff may believe that if only “they” were more understanding, worked harder, or knew what it was really like, “we” could do the best job. 
						Of course, this same thinking is prevalent in the other groups except in reverse.
					</p>
				</td>
				<td>
					<img src="Styles/team_placeholder.jpg" alt="team placeholder" width="500" height="400" class = "brush">
				</td>
			</tr> -->
			<tr class = "alt_row">
				<td>
					<h3> Our Service </h3>
					<p> 
						We offer a friendly space where you can come with your family or friends and enjoy some traditional steamed pork buns
						and a very soft cheese cake. 
					</p>
					<td>
						<img src="Styles/Service.jpeg" alt="service placeholder" width="600" height="300" class = "brush">
					</td>	
				</td>	
			</tr>			
		</table>
		<br/>
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
		<script src="index.js"></script>
		<!-- script for the cart icon-->
		<script src="Menu.js"></script>
	</body>
</html>
