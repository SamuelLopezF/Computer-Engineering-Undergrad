<!--
	Last Edited By: Bryan
	Edit Date: 24-Nov-2020
	Edit Number: 0
    Details:
        - This will output the items from the products database into the menu page. 
        - I used bootstrap so the items go to the next row.
        - Couldn't get the brush borders. 
        - Filter not working.
        - Database has new column called 'type'
-->
		


<!-- CONNECTION TO THE DB ALREADY ESTABLISHED -->
<?php
    include ('header.php');
?>
<!-- Filters -->
<section id = "filter_menu" class = "small_brush">
            <form action = "">
                <table>
                    <tr>
                        <td>
                            <h4> Filters </h4>
                            <input type = "checkbox" name = "filter" value = "biscuit" checked class = "filter">
                            <label> Biscuits </label> <br/>
                            <input type = "checkbox" name = "filter" value = "cake" checked class = "filter">
                            <label> Cakes </label> <br/>
                            <input type = "checkbox" name = "filter" value = "bites" checked class = "filter">
                            <label> Bites </label> <br/>
                            <input type = "checkbox" name = "filter" value = "buns" checked class = "filter">
                            <label> Buns </label> <br/>
                            <input type = "checkbox" name = "filter" value = "misc" checked class = "filter">
                            <label> Miscellaneous </label> <br/>
                        </td>
                    </tr>
                    <tr>
                        <td class = "button_cell"><br/><button type = "button" id = "filter_button"> Filter </button></td>
                    </tr>
                </table>
            </form>
            <br/>
        </section>

    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link type = "text/css" rel = "stylesheet" href = "css/template.css"/>
    <style type = "text/css" rel = "stylesheet">
            /* .menuItem:hover {background-color: var(--light_beige);} */

            #filter_menu {
                position: fixed;
                left: 1%;
                top: 33%;
                text-align: left;
                background-color: var(--light_beige);
            }

            #filter_menu h4 {
                margin-top: 10%;
                margin-bottom: 10%;
                padding-top: 0;
                padding-bottom: 0;
                text-align: center;
            }

            .button_cell  {text-align: center;}
        </style>


    <!-- select rows from products database-->

    
        
    <div class='container'>
    <?php

    // THIS IS THE SQL (COMMAND/ACTION/STATEMENT). 
    // IN THIS CASE, I'M SELECTING EVERYTHING IN THE DATABASE
    $sql = "SELECT * FROM products;";

    // EXACUTES THE SQL CODE IN phpMyAdmin
    $result = mysqli_query($connect, $sql);

    // CHECKS IF WE HAVE ROWS IN THE DATABASE
    $resultCheck = mysqli_num_rows($result);

    // IF $resultCheck > 0   (HAS ITEMS INSIDE)
    if($resultCheck > 0){
    // IF WE HAVE ITEMS INSIDE, DISPLAY INFORMATION

        // $row IS THE ARRAY CONTAINING THE DATA FROM THE DATABASE
        while ($row = mysqli_fetch_assoc($result)){
            ?>
                        <div class='col-sm-6 col-md-4 col-lg-4 <?php echo $row['type']; ?> menuItem'>
                            <figure>
                                <h4> <?php echo $row['name'] ?> </h4>
                                <a href = "<?php echo $row['url'];  ?>" >
                                <img class = "small_brush" src="<?php echo 'Styles/'.$row['image'];  ?>" alt="Almond cookies.jpg" 
                                    height="210px" width="270px" >
                                </a>
                            </figure>
                        </div>
            
            <?php
        };

    // ELSE DO THIS
    }
    ?>

</div>

<?php
    include ('footer.php');
?>