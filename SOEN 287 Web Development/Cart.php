<?php require_once("PHP/Cart_Cookies/Cart_Cookie.php"); ?>
<?php require_once("PHP/Cart_Cookies/Cookie_Hash_Functions.php"); ?>
<?php require_once("PHP\Templates\Template_Functions.php"); ?>
<?php session_start();?>
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
        <style type = "text/CSS">
            table.cartTable {
              width: 75%;
              border-collapse: collapse;
            }
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
                    
                    <th class="cart current_page" id='cartIconTopRight'><a href="Cart.php" class = "current_page"><span class="qty" id= 'cartIconTopRightQuantity'><?php if(isSet($menu)) cartSize($menu); else echo("0");?></span><img src="Styles/Cart.png" alt="Cart.html" width="40px" height="40px"/></a></th>
                    
                </tr>
            </table>
        </nav>
    </header> <br/>
    
    <table class = "cartTable">
      <form action = "" method = "POST">
        <tr style = "background-color: var(--beige);">
          <th>Item</th>
          <th colspan = "3">Number</th>
          <th>Cost</th>
        </tr>
        <?php
          require_once("PHP/Cart_Cookies/Row_Creator.php");
          $fail = true;
          $empty = true;
          if(isset($_COOKIE["cart_cookie"])){
            $menu = cookieToHash($_COOKIE["cart_cookie"]);
            $empty = true;
            foreach($menu as $key=>$value){
              $fail = false;
              if($menu[$key] > 0){
                createRow($key,$value);
                $empty = false;
              }
            }
            $total = 0;
            foreach($menu as $item => $quantity){
                if($quantity > 0){
                    $string = createString($item, $quantity);
                    $price = calculatePrice($item, $quantity);
                    $total += $price;
                }
            }
            if($empty){
              print"<tr><td colspan='5'> <h4> It looks like your cart is empty.</h4> </td></tr>";
            }
	    else{
		$totalout= number_format($total, 2);
		print "<tr><td colspan='4'></td><td> <h4> $totalout\$</h4> </td></tr>";
            }
          }
          if($fail){
            print"<tr><td colspan='5'> <h4> Oops. Looks like we couldn't process your order </h4> </td></tr>";
          }

        ?>
      </form> <br/>
    </table>

    <br/>
    <form action = "checkout.php" method = "POST">
      <table style = "width: 75%;">
        <tr>
          <td style = "text-align: left;">
            <?php
              if($empty || $fail )
                echo "<button type = 'submit' name = 'submit_order' disabled> Submit Order </button>";
              else
                echo "<button type = 'submit' name = 'submit_order'> Submit Order </button>";
            ?>
         </td>
        </tr>
      </table>
    </form><br/>

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
  <script type="module" src="JavaScript/Cart.js"></script>
  <script type = "text/JavaScript" src = "JavaScript/CartRowSelector.js"></script>
</body>
</html>
