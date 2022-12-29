<?php
include "header.php";
include "db_conn.php";
include "comments_functions.php";

$id = $_POST["id"];
$username = $_POST["username"];
$date = $_POST["date"];
$comment = $_POST["comment"];

echo "<form method='POST' action='".editComment($connect)."'>
        <input type='hidden' name='id' value='".$id."'>
        <input type='hidden' name='username' value='".$username."'>
        <input type='hidden' name='date' value='".$date."'>
        <textarea name='comment' cols='40' rows='5s'>$comment</textarea>
        <br/>
        <button type='submit' name='submit'>Submit</button>
    </form>";
?>
