<?php
require_once("PHP\Templates\Template_Functions.php");
// for debugging purposes 
    $_POST;
    print_r($_POST);
// validates entries from the user to conform to regex expressions. Then checks if user already exists in database.
    if (!empty($_POST)) 
    {
        $email_input = $_POST['email_registration'];
        $password_ok = validate_password($_POST['password_registration']);
        $email_ok = validate_email($_POST['email_registration']);
        $username_ok = validate_username($_POST['username_registration']);
    }
    if($password_ok && $email_ok && $username_ok)
    {
            echo 'passed regex';
            $already_exists  = check_if_unique_and_create();
            if (!$already_exists) {
                $filename =  $email_input;
                createFile($filename);
                header("Location: account.php?status=registersuccess");
            }else{
                header('Location: register.php?error=usernamealreadyexists');
            }
    }else{
        echo 'did not pass';
    }
// connects to mysqli database with a root user and no password. Set this way for simplicity and sharing compatibility.
function connect_to_database()
{
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "soen_admin";
    
    $connect = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);


    if($connect)
    {
        echo ' connected  to database <br>';
    }else{
        echo ' not connected';
    }
    return $connect;
}
// checks if the email is already taken with a prepared mysqli statement. Printing is for debugging.
function check_if_unique_and_create(){

    $email = $_POST['email_registration'];
    echo $email . "<br>";
    $connect = connect_to_database();
    $sql = "SELECT * FROM `user_account` WHERE  email = ?;";

    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        echo ' something went wrong sql';
    }else {
        echo 'stmt prepare worked  <br> ';
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);


        $result_data = mysqli_stmt_get_result($stmt);
        if($row_from_database = mysqli_fetch_assoc($result_data))
        {   
            //if its true, username already exits 
            print_r ($row_from_database);
            echo '<br> fetch assoc true user already exists<br>';
            print_r($result_data);
            mysqli_stmt_close($stmt);
            return true;

        }else{
            //if its false, unsername is unique process to insert data into sqli db 
            $_SESSION['registration_status'] = "true";
            echo ' fetch assoc false user is unique  <br> ';
            print_r($result_data);
            echo "<br>";
            create_user($_POST['email_registration'], $_POST['password_registration'], $_POST['username_registration']);
            mysqli_stmt_close($stmt);
            return false;
        }
       
    }
}
// creates a new user if the user is unique and passed regex expressions
function create_user($email, $password, $username)
{
    $connect = connect_to_database();
    $sql = "INSERT INTO `user_account`(`username`, `pwrd`, `email`) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        echo ' something went wrong sql';
    }
        echo 'stmt prepare worked  <br> ';
        mysqli_stmt_bind_param($stmt, "sss", $username,$password, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['registration_status'] = 'You sucessfully registered';
}
// regex functions to check if the inputs are valid
function validate_password($password)
{
    $regex_password = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if(!preg_match($regex_password ,$password))
    {
        header("location: register.php?error=invalidpassword");
        exit;
    }
    return true;
}

function validate_username($username_input)
{   
    if(empty(trim($username_input)))
    {
        return false;
    }
    $regex_name = '/^(?![\s\S]*[^\w -]+)[\s\S]*?$/';
    if(!preg_match( $regex_name , $username_input)){
        header("location: register.php?error=invalidusername");
        exit;
    }
    return true;
}

function validate_email($email_input)
{
    if(empty(trim($email_input)))
    {
        return false;
    }
    if(!filter_var($email_input, FILTER_VALIDATE_EMAIL)){
        header('location: register.php?error=invalidemail');
        exit;
    }
    return true;
}
?>
