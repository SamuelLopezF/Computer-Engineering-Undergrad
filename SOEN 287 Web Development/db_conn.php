<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbName = "soen_admin";

$connect = mysqli_connect($dbServername, $dbUsername, "", $dbName);

if(!$connect){
    die("Connection failed: ".mysqli_connect_error());
}
?>