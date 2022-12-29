<?php require_once("PHP/Cart_Cookies/Cart_Cookie.php"); ?>
<?php require_once("PHP/Cart_Cookies/Cookie_Hash_Functions.php"); 
session_start();
?>
<?php
    if(isset($_COOKIE["cart_cookie"]))
    {
        $menu = cookieToHash($_COOKIE["cart_cookie"]);
    }
?>  
<!-- ========================= End of Important PHP ========================= -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account | Dulceria China</title>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
	<meta name = "keywords" content = "dulceria china, restaurant, bakery, home, cantonese, baked goods, buns, account, login, signup"/>
	<meta name = "description" content = "Log in to order or deliver food, as well as to gain access to great food at a click of a button!"/>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href="Styles/template.css" rel="stylesheet">   
</head>
<body>
    <!-- Header/Nav-->
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
                    <?php if(!empty($_SESSION['login_status']) && $_SESSION['login_status'] === "logged in")
                    {
                        echo "<th><a href = 'profile.php'> My Profile </a></th>";
                        echo "<th><a href = 'logout.php'> Log out </a></th>";
                    }else{
                        echo '<th class = "current_page"><a href = "account.php" class = "current_page"> Log In </a></th>';
                        echo '<th><a href = "register.php"> Sign up </a></th>';
                    }
                    ?>
                    <th class="cart" id='cartIconTopRight'><a href="Cart.php"><span class="qty" id= 'cartIconTopRightQuantity'><?php echo isset($menu)? cartSize($menu): "0" ;?></span><img src="Styles/Cart.png" alt="Cart.html" width="40px" height="40px"/></a></th>
                    
                </tr>
            </table>
        </nav>
    </header>

    <!-- Body Text -->
    <?php if(empty($_SESSION['login_status']))
    {
    echo
    '<div class="row">
        <div class="col"><h3>Log in!</h3>
            <p>
                Register or login to your Dulceria China. </br>
                Thanks to this account, you can create custom product lists that will be saved and accesible in one click!
                You will also recieve monthly updates on our limited time offers.
            </p>
        </div>
    </div>
    
    <!-- Login Form -->
    <form id = "login" class = "small_brush" action = "login_validation.php" method = "POST">
        <table id = "login_table_1">
            <tr><th> Email Address </th></tr>
            <tr><th> <input type = "email" placeholder = "email@dulceria.com" id = "email" name = "email_login" /> </th></tr>
            <tr><th> Password </th></tr>
            <tr><th> <input type = "password" placeholder = "Password" id = "password" name = "password_login" /> </th></tr>';
            if(!empty($_GET['error']) && $_GET['error'] == 'invalidentry')
            {
                    echo '<p> wrong username or password please try again <p>';
            }
            if(!empty($_GET['status']) && $_GET['status'] == 'registersuccess')
            {
                echo "<p> You created your account successfully, you can now log in and check out the template cart tool we made for you</p>";
            }
           echo ' <tr><th> <button type = "submit" id = "logininput" name = "check_login" value = "Log in"> Log in</button></th></tr>
            <tr><td>Not a member ?<a href="register.php">Register here</a></td></tr>
        </table>
    </form>';
    }else{
        echo '<div class="row">
        <div class="col"><h3>Logged in!</h3>
            <p>
               You logged in into your account. Go check my profile for more information. </br>

            </p>
        </div>
    </div>';
    }
    ?>
    <!-- Footer -->
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
    </script>
    <script src="JavaScript/MonthSpecials.js">      
    </script>
</body>
</html>
