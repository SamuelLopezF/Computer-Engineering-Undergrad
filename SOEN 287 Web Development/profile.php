<?php
session_start();
if (empty($_SESSION['login_status'])) {
  header("Location: account.php");
}else{
    // print_r ($_SESSION['login_status']);
}
?>

<?php 
    require_once("PHP/Cart_Cookies/Cart_Cookie.php");
    require_once("PHP/Cart_Cookies/Cookie_Hash_Functions.php");
    require_once("PHP/Templates/Template_Functions.php");
    
    if(isset($_POST["checkout"]))
        templateToCart($_SESSION['username_logged_in'], $_POST["checkout"]);

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
    <style type = "text/CSS">
        input {
            padding: 5px;
            text-align: center;
        }

        tr.itemNames td {
            font-size: 80%;
            }
        tr.itemQuant td input {width: 50%;}
        tr.templateRow table tr td {padding: 5px 0px;}
        tr.orderRow table tr td {padding: 5px 0px;}
        tr.templateRow table {width: 80%;}
        tr.orderRow table {width: 80%;}
        #profileTable {width: 80%;}
    </style>
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
                    <?php if(!empty($_SESSION['login_status']) && $_SESSION['login_status'] == 'logged in')
                    {
                        echo "<th class = 'current_page'><a href = 'profile.php' class = 'current_page'> My Profile </a></th>";
                        echo "<th><a href = 'logout.php'> Log Out</a></th>";
                    }else{
                        echo '<th><a href = "account.php"> Log In </a></th>';
                        echo '<th><a href = "register.php"> Sign up </a></th>';
                    }
                    ?>
                    <th class="cart" id='cartIconTopRight'><a href="Cart.php"><span class="qty" id= 'cartIconTopRightQuantity'><?php echo isset($menu)? cartSize($menu): "0" ;?></span><img src="Styles/Cart.png" alt="Cart.html" width="40px" height="40px"/></a></th>
                    
                </tr>
            </table>
        </nav>
    </header>
    <table id = 'profileTable'> 
        <?php           
        $user_login = $_SESSION['username_logged_in'];
            if(isset($_POST["submit"]))
                updateTemplate($user_login, HTMLToTemplateString(), $_POST["submit"]);

            echo "<tr> <td colspan = '14'> <h3> Templates </h3> </td> </tr>";

            echo templateStringToHTML(getTemplate($user_login, 1), 1);
            echo templateStringToHTML(getTemplate($user_login, 2), 2);
            echo templateStringToHTML(getTemplate($user_login, 3), 3);
                    
            echo "<tr> <td colspan = '14'> <h3> Order History </h3> </td> </tr>";

            foreach(getRecentOrders($user_login) as $order)
                echo orderToHTML($order);
        ?>
    </table>

    <br/><br/>
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

    <script type = "text/JavaScript">
        let templateRows = document.querySelectorAll(".templateRow");
        for(let i = 0 ; i < templateRows.length ; i++)
            if(i % 2 == 0)
                templateRows[i].classList.add("alt_row");
        
        let orderRows = document.querySelectorAll(".orderRow");
        for(let i = 0 ; i < orderRows.length ; i++)
            if(i % 2 == 0)
                orderRows[i].classList.add("alt_row");
    </script>
</body>
