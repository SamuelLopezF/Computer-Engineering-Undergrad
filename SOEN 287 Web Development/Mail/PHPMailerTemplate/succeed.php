<?php require_once(__DIR__."/../../PHP/Cart_Cookies/Cart_Cookie.php"); ?>
<?php require_once(__DIR__."/../../PHP/Cart_Cookies/Cookie_Hash_Functions.php"); ?>
<?php require_once(__DIR__."/../../PHP/Cart_Cookies/Row_Creator.php"); ?>
<?php require_once(__DIR__. "/../../PHP/Templates/Template_Functions.php"); ?>
<?php session_start();?>
<!--
    // File Description: Sends Contact Us Email
    // Last Edited By: Sobhan
    // Edit Date: 06-Dec-2020
    // Edit #: 1
    // Edit Description: Updated assignment template for this
-->
<!-- PHP -->
<?php
    if(isset($_COOKIE["cart_cookie"]))
        $menu = cookieToHash($_COOKIE["cart_cookie"]);
?>  
<!-- ========================= End of Important PHP ========================= -->
<!DOCTYPE html>
<html lang = "en">
    <head>
        <title> Success | Dulceria China </title>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
	    <meta name = "keywords" content = "dulceria china, restaurant, bakery, home, cantonese, baked goods, buns, contact us, contact information"/>
	    <meta name = "description" content = "If you have any concerns or want to discuss something, feel free to contact us!"/>
	    <link rel="shortcut icon" type="image/x-icon" href="../../favicon.ico" />
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
		<link href="../../Styles/template.css" rel="stylesheet">
		<title> a2q3 </title>
        <style type = "text/CSS">
            #contact_info * {line-height: 6px;}
        </style>
        
        
    </head>

    <body>
		<header>
            <nav>
                <table>
                    <tr>
                        <th class = "logo"> <a href = "../../index.php" class = "logo"><img width="100" src="../../Styles/BakeryLogo.png" alt="Dulceria China logo" class = "logo"/> </a></th>
                        <th><a href = "../../index.php"> Home </a></th>
                        <th><a href = "../../menu.php"> Menu </a></th>
                        <!-- <th><a href = "order.html"> Order </a></th> -->
                        <th><a href = "../../about_us.php"> About Us </a></th>
                        <th><a href = "../../contact_us.php"> Contact Us </a></th>
                        <?php if(!empty($_SESSION['login_status']) && $_SESSION['login_status'] == 'logged in')
                    {
                        echo "<th><a href = '../../profile.php'> My Profile </a></th>";
                        echo "<th><a href = 'logout.php'> Log Out</a></th>";
                    }else{
                        echo '<th><a href = "../../account.php"> Log In </a></th>';
                        echo '<th><a href = "../../register.php"> Sign up </a></th>';
                    }
                    ?>
                        
                        <th class="cart" id='cartIconTopRight'><a href="../../Cart.php"><span class="qty" id= 'cartIconTopRightQuantity'><?php if(isSet($menu)) cartSize($menu); else echo("0");?></span><img src="../../Styles/Cart.png" alt="Cart.html" width="40px" height="40px"/></a></th>
                        
                    </tr>
                </table>
            </nav>
        </header>


<!-- Processes and sends the email -->

		<?php
            /**
             * PHP Template for using PHPMailer to send emails.
             * Before sending emails using the Gmail's SMTP Server, you must make some of the security and permission level     
             * settings under your Google Account Security Settings. Please create a dummy account as you will have to put in 
             * username and password
             * Make sure that 2-Step-Verification is disabled. Follow the link https://myaccount.google.com/security
             * Turn ON the "Less Secure App" access at https://myaccount.google.com/u/0/lesssecureapps 
             */

            //Import the PHPMailer class into the global namespace
            //You don't have to modify these lines. 
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;

            //SMTP needs accurate times, and the PHP time zone MUST be set
            //This should be done in your php.ini, but this is how to do it if you don't have access to that
            date_default_timezone_set('Etc/UTC');

            require 'vendor/autoload.php';

            //Create a new PHPMailer instance
            $mail = new PHPMailer;
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // SMTP::DEBUG_OFF = off (for production use)
            // SMTP::DEBUG_CLIENT = client messages
            // SMTP::DEBUG_SERVER = client and server messages
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            //Set the hostname of the mail server (We will be using GMAIL)
            $mail->Host = 'smtp.gmail.com';
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = 587;
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication
            $mail->Username = 's287.dummy.smp@gmail.com';
            //Password to use for SMTP authentication
            $mail->Password = 'r3411ystr0ngp455';
            //Set who the message is to be sent from
            $mail->setFrom('s287.dummy.smp@gmail.com', 'Dummy Account');
            //Set an alternative reply-to address
            //$mail->addReplyTo('replyto@example.com', 'First Last');
            if(!isset($_POST["submit"]) || !isset($_COOKIE["cart_cookie"]) || !isset($_POST["email"]) )
                echo("<p> Sorry. We were unable to complete your order.</p>");
            else{
            //Set who the message is to be sent to email and name
            $mail->addAddress($_POST["email"], $_POST["first_name"]." ".$_POST["last_name"]);
            //Name is optional
            //$mail->addAddress('recepientid@domain.com');

            //You may add CC and BCC
            //$mail->addCC("recepient2id@domain.com");
            //$mail->addBCC("recepient3id@domain.com");

            $mail->isHTML(true);

            //You can add attachments. Provide file path and name of the attachments      
            //Filename is optional
            // $mail->addAttachment("PHPMailerTemplate/images/welcome.jpg"); 

            // creating email message
            $menu = cookieToHash($_COOKIE["cart_cookie"]);
            $dataBase = "../../Database/Item_Info.txt";
            $output = "";
            $total = 0;
            foreach($menu as $item => $quantity){
                if($quantity > 0){
                    $string = createString($item, $quantity);
                    $price = calculatePrice($item, $quantity);
                    $total += $price;
                    $output = $output." ".$string;
                }
            }


            //Set the subject line
            $mail->Subject = 'Dulceria China - Order';
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->Body = "<p> Dear ".$_POST["first_name"]." ".$_POST["last_name"]. ", </p>
                <p> Your order has been placed.</p>
                <p> This is your complete order: </p>".
                $output."
                <p> The total price is $$total </p>
                <p> Thank you, </p>
                <p> Dulceria China </p>";



            //You may add plain text version using AltBody
            //$mail->AltBody = "This is the plain text version of the email content";
            //send the message, check for errors
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo '<p>Success! A confirmation email has been sent!</p>';
                // if logged in add order (username, cookie)
                if(!empty($_SESSION['login_status']) && $_SESSION['login_status'] == 'logged in')
                {
                    $user =$_SESSION['username_logged_in'];
                    addOrder($user, $_COOKIE["cart_cookie"]);
                }
                unset($_COOKIE["cart_cookie"]);
                setcookie("cart_cookie","", time() - 60*60, "/");
            }
            }
            ?>
		<footer>
            <table>
                <tr id = "email">
                    <td>
                        <img src = "../../Styles/email.png" alt = "Email" width = "25px" height = "25px"/>
                    </td>
                    <td>
                        <a href = "mailto:dulceriachina.ec@gmail.com">dulceriachina.ec@gmail.com</a>
                    </td>
    
                </tr>
                <tr id = "telephone">
                    <td>
                        <img src = "../../Styles/phone.png" alt = "Phone" width = "25px" height = "25px"/>
                    </td>
                    <td>
                        (04) 251-0363 - (593) 997-045-024
                    </td>
    
                </tr>
                <tr id = "facebook">
                    <td>
                        <img src = "../../Styles/facebook.png" alt = "Facebook" width = "25px" height = "25px"/>
                    </td>
                    <td>
                        <a href = "https://www.facebook.com/dulceriachina/" target = "_blank"> facebook.com/dulceriachina</a>
                    </td>
    
                </tr>
                <tr id = "instagram">
                    <td>
                        <img src = "../../Styles/instagram.png" alt = "Instagram" width = "25px" height = "25px"/>
                    </td>
                    <td>
                       <a href="https://www.instagram.com/dulceriachina/">@dulceriachina</a> 
                    </td>
    
                </tr>
            </table>
            <p> ©2020 Dulceria China </p>
        </footer>
        
        	<script src="../../JavaScript/index.js"></script>
	</body>
</html>