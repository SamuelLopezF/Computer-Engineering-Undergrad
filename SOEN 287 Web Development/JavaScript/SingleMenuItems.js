/*
    File Description: Client-side price conversion for single menu item pages
	Last Edited By: Sobhan
	Edit Date: 26-Nov-2020
	Edit Number: 2
	Edit Details:
		Commented out the change in cart
*/

// menu item + price
const MENU_ITEMS = {
    'almond_cookies': 0.50,
    'cheese_cake': 1.00,
    'chicken_biscuit': 0.50,
    'egg_tart': 1.00,
    'guava_bites':  0.60,
    'coconut_mochi': 1.00,
    'pineapple_bites': 0.60,
    'pineapple_cake': 1.00,
    'tan_wong_su': 1.00,
    'tau_sa_pen': 0.70,
    'pork_bun': 0.80,
    'red_bean_paste_bun': 0.80,
    'coconut_bun': 0.80,
    'custard_bun': 0.80
}

let pieces = document.querySelectorAll(".input_pieces");
let prices = document.querySelectorAll(".input_price");
let buttons = document.querySelectorAll(".add_btn");
let cartQuantity = document.getElementById("cartIconTopRightQuantity");

// For all buttons on page
for(let i = 0 ; i < buttons.length ; i++){

    // set initial values based on the menu item
    pieces[i].placeholder = "0";
    pieces[i].value = 0;
    prices[i].placeholder = "$" + (MENU_ITEMS[buttons[i].id]).toFixed(2);
    prices[i].value = "$0.00";

    // set the price to change whenever user changes num of pieces
    pieces[i].addEventListener("change",function(){
        // Get Quanity
        let quantity = parseInt(pieces[i].value);
        if(isNaN(quantity) || quantity < 0)
            prices[i].value = "";
        else
            // Price = quantity * price per piece
            prices[i].value = "$" + (quantity*parseFloat((prices[i].placeholder).substring(1))).toFixed(2);
    });

    // // add quantity to cart (just visual)
    // buttons[i].addEventListener("click", function(){
    //     let newQuantity = parseInt(pieces[i].value);
    //     if(!isNaN(newQuantity) && newQuantity >= 0)
    //         cartQuantity.innerHTML = parseInt(cartQuantity.innerHTML) + newQuantity;
    // });
}

