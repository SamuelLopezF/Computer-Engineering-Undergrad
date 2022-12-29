<?php
date_default_timezone_set('America/Toronto');

    function setComment($connect){
        if(isset($_POST["submit"])){
            $username = $_POST["username"];
            $date = $_POST["date"];
            $comment = $_POST["comment"];

            $sql = "INSERT INTO comments (username, date, comment) VALUES ('$username', '$date', '$comment')";

            $result = $connect->query($sql);
        }
    }

    function getComment($connect){
        $sql = "SELECT * FROM comments";
        $result = $connect->query($sql);
        while($row = $result->fetch_assoc()){
            echo "<div class='comment_box'><p>";
                echo $row['username'].":<br/>";
                echo $row['date']."<br/>";
                echo $row['comment']."<br/><br/>";
            echo "</div>";

            // echo </p>
            // <form method='POST' action='".deleteComment($connect)."' >
            //         <input type='hidden' name='id' value='".$row['id']."'>
            //         <button type='submit' name='delete'>Delete</button>
            //     </form>
            //     <form method='POST' action='edit_comment.php'>
            //         <input type='hidden' name='id' value='".$row['id']."'>
            //         <input type='hidden' name='username' value='".$row['username']."'>
            //         <input type='hidden' name='date' value='".$row['date']."'>
            //         <input type='hidden' name='comment' value='".$row['comment']."'>
            //         <button>Edit</button>
            //     </form>
                // </div>";
        }
        
    }

    // function editComment($connect){
    //     if(isset($_POST["submit"])){
    //         $id = $_POST["id"];
    //         $username = $_POST["username"];
    //         $date = $_POST["date"];
    //         $comment = $_POST["comment"];

    //         $sql = "UPDATE comments SET comment='$comment' WHERE id='$id'";
    //         $result = $connect->query($sql);
    //         header("Location: index.php");
    //     }
    // }

    // function deleteComment($connect){
    //     if(isset($_POST["delete"])){
    //         $id = $_POST["id"];

    //         $sql = "DELETE FROM comments WHERE id='$id'";
    //         $result = $connect->query($sql);
    //         header("Location: index.php");
    //     }
    // }
?>
