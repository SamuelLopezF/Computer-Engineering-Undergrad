<?php

    //     File Description: Holds cart information on client side in the form of cookies
    //                     To be placed at the top of all pages
    //     Last Edited By: Sobhan
    //     Edit Date: 26-Nov-2020
    //     Edit Number: 2
    //     Edit Description: Created the file

    // duration of cookie (24 hours by default);
    $duration = 60*60*24;
    if(! isset($_COOKIE["cart_cookie"])) {

        $cart = [
            "almond_cookies",  0,
            "cheese_cake", 0,
            "chicken_biscuit", 0,
            "egg_tart", 0,
            "guava_bites", 0,
            "coconut_mochi", 0,
            "pineapple_bites", 0,
            "pineapple_cake", 0,
            "tan_wong_su", 0,
            "tau_sa_pen", 0,
            "pork_bun", 0,
            "red_bean_paste_bun", 0,
            "coconut_bun", 0,
            "custard_bun", 0,
        ];
        
        // creates the cookie
        setcookie("cart_cookie", implode(" ", $cart), time()+$duration, "/");
    }
?>

