<?php require_once("PHP/Cart_Cookies/Cart_Cookie.php"); ?>
<?php require_once("PHP/Cart_Cookies/Cookie_Hash_Functions.php"); ?>
<?php session_start() ?>
<?php
    incrementCart();
    decrementCart();
    if(isset($_COOKIE["cart_cookie"]))
        $menu = cookieToHash($_COOKIE["cart_cookie"]);
    
?>  
<!-- ========================= End of Important PHP ========================= -->
<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Cart | Dulceria China</title>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <meta name = "keywords" content = "dulceria china, restaurant, bakery, home, cantonese, baked goods, buns, cart, complete order"/>
        <meta name = "description" content = "Ready to finish your purchase? Head down to our cart page!"/>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link type = "text/css" rel = "stylesheet" href = "Styles/template.css"/>
        <link type = "text/css" rel = "stylesheet" href = "Styles/menu items.css"/>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
		integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" 
		crossorigin=""/>
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
		integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" 
		crossorigin=""></script>
		<script src ="JavaScript/map.js" type ="text/javascript" defer></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<script src ="JavaScript/checkout.js" type ="text/javascript" defer></script>
        <style type = "text/CSS">

            #checkoutForm table {
                border-collapse: collapse;
                width: 50%;
            }
            #checkoutForm table td {
                vertical-align: top;
                text-align: center;
                width: 50%;
            }
            
            input {
                padding: 5px;
                text-align: center;
            }

            #address, #address2 {width: 90%;}

            #expMonth, #expYear {width: 15%;}

            #email {width: 50%;}

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
    </header> <br/>

    <form id = "checkoutForm" action = "Mail/PHPMailerTemplate/succeed.php" method = "POST">    

        <table> 
            <tr class = "alt_row"><td colspan = "2"> <br/> Personal Information </td></tr>
            <tr class = "alt_row">
                <td> <br/>
                    <label>First Name *</label> <br/>
                    <input type = "text" name = "first_name" id = "first_name" placeholder = "John" pattern = "[A-Za-z']{1,}" required/>
                </td>
                <td>
                    <br/>
                    <label>Last Name *</label> <br/>
                    <input type = "text" name = "last_name" id = "last_name" placeholder = "Smith" pattern = "[A-Za-z']{1,}" required/>
                </td>
            </tr>
            <tr class="alt_row">
                <td colspan = "2"><br/><input type = "email" name = "email" id = "email" placeholder = "sample@email.com" required/><br/><br/></td>
            </tr>

            <tr><td colspan = "2"> <br/> Credit Card Information </td></tr>
            <tr>
                <td>
                    <br/>
                    <label>Credit Card Number *</label> <br/>
                    <input type = "text" name = "credit" id = "credit" placeholder = "0000-0000-0000-0000" pattern = "[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}" required/>
                    <br/><br/> 
                </td>
                <td>
                    <br/>
                    <label>Security Code *</label> <br/>
                    <input type = "text" name = "ccv" id = "ccv" placeholder = "123" pattern = "[0-9]{3}" required/> <br/>
                    <label>Expiry Date *</label> <br/>
                    <input type="number" name="expMonth" id="expMonth" placeholder = "MM" pattern = "[0-9]{2}" required>
                    <span> / </span>
                    <input type="number" name="expYear" id="expYear" placeholder = "YY" pattern = "[0-9]{2}" required> <br/><br/> 
                </td>
            </tr>

            <tr class = "alt_row"><td colspan = "2"> <br/> Shipping Information  </td></tr>
            <tr class = "alt_row">
                <td>
                    <br/>
                    <label>Address Line 1 *</label> <br/>
                    <input type = "text" name = "address" id = "address" placeholder = "#50, 0000 Example Avenue" require/> <br/>
                    <label>Address Line 2 </label> <br/>
                    <input type = "text" name = "address2" id = "address2" placeholder = "District"/> <br/>
                    
                </td>
                <td>
                    <br/>
                    <label>City * </label> <br/>
                    <input type = "text" name = "city" id = "city" placeholder = "City"/> <br/>
                    <label>Postal Code * </label> <br/>
                    <input type = "text" name = "postal" id = "postal" pattern = "[A-Z][0-9][A-Z][- ][0-9][A-Z][0-9]" placeholder = "A1A-1A1" required/> <br/><br/> 
                    <br/>
                </td>
            </tr>
            <tr class = "alt_row">
                <td colspan="2">
                    <br/>
                    <label> Collection Type </label>
                    <select id = "deliveryType" name = "deliveryType">
                        <option value = "delivery">Delivery</option>
                        <option value = "pickup"> Pickup</option>
                    </select>
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style = "text-align: left;">
                    <br/>
                    <button type = "submit" name = "submit" id = "submit">Complete Purchase</button>
                </td>
            </tr>
        </table>
        <br/>
	
		<!-- <table>
			
			<tr><div>
				<label for="name">Name: </label>
				<input type="text" name="name" id="name">
			</div></tr>
		  
			<tr><div>
				<label for="creditCard">Card Number</label>
				<input type="number" name="creditCard" id="creditCard"  style="width: 12em">
			</div></tr>
		 
			<tr><div>
				<label for="cvv">Security Code/CVV</label>
				<input type="number" name="cvv" id="cvv"  style="width: 3em">
			</div></tr>
			
			<tr><div>
				<label for="Expiration">Exp. (MM/YY)</label>
				<input type="number" name="expMonth" id="expMonth"  style="width: 2em">
				<span> / </span>
				<input type="number" name="expYear" id="expYear"  style="width: 2em">
			</div></tr>
		  
			<tr><div>
				<label for="bAddr">Billing Address</label>
				<input type="text" id="bAddr" name="bAddr">
			</div></tr>
			
			<tr><div>
				<h3>Shipping method: </h3><br>
				<label>
				<input type="checkbox" id="pu" class = "shippingMethod" value = "1" name="dm"  />Pick up</label><br>
				<label>				
				<input type="checkbox" id="fd" class = "shippingMethod" value = "1" name="dm" onchange="delivery()" />Free delivery</label>
			</div></tr>
		  
			<tr><div id = "delivery" style="display:none">
				<label for="sAddr">Shipping Address</label>
				<input type="text" id="sAddr" name="sAddr"><br>
				<input type="checkbox" id="same" name="same" onchange="addressFunction()" />
				<label for="sameAddr">Same as billing address</label>
			</div></tr>
			
			<tr><div>
			<p id = "error"></p><br>
			<p id = "tooFar"></p><br>

			<button id = "checkout" name = "submit" onclick= "validate">Checkout</button><br><br>
			</div></tr>
		</table>-->
	</form> 
		
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
</body>
</html>
