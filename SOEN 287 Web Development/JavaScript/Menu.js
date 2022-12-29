/*
	Last Edited By: Sobhan
	Edit Date: 08-Nov-2020
	Edit Number: 1
	Edit Details:
		To help keep track of the different versions, I'm adding this to the top of every
		file. Please update this info whenever you want to change anything. This makes it easier to
		keep track of changes/the latest version.
        Thank you!
        
        Added price conversion
	Fixed a bug in the price conversion;
		
*/

// Automatically adds prices/updates them

// Price Constants

const ALMOND_COOKIE_PRICE = 0.50;
const CHEESE_CAKE_PRICE = 1.00;
const CHICKEN_BISCUIT_PRICE = 0.50;
const EGG_TART_PRICE = 1.00;
const GUAVA_BITES_PRICE = 0.60;
const COCONUT_MOCHI_PRICE = 1.00;
const PINEAPPLE_BITES_PRICE = 0.60;
const PINEAPPLE_CAKE_PRICE = 1.00;
const TAN_WONG_SU_PRICE = 1.00;
const TAU_SA_PEN_PRICE = 0.70;
const PORK_BUNS_PRICE = 0.80;
const RED_BEAN_PASTE_PRICE = 0.80;
const COCONUT_BUN_PRICE = 0.80;
const CUSTARD_BUN_PRICE = 0.80;

const PRICES = [ALMOND_COOKIE_PRICE, CHEESE_CAKE_PRICE, CHICKEN_BISCUIT_PRICE,
    EGG_TART_PRICE, GUAVA_BITES_PRICE, COCONUT_MOCHI_PRICE, PINEAPPLE_BITES_PRICE,
    PINEAPPLE_CAKE_PRICE, TAN_WONG_SU_PRICE, TAU_SA_PEN_PRICE, PORK_BUNS_PRICE,
    RED_BEAN_PASTE_PRICE, COCONUT_BUN_PRICE, CUSTARD_BUN_PRICE];

//toFixed(2) prints exactly 2 points after decimal point.
function piecesToPrice(){
    if(this.value.search(/^\d/) != -1 ){
        let pieces = parseInt(this.value);
        let id = this.id;
        let price = parseFloat(document.getElementById("price" + id.substring(5)).placeholder);
        let new_price = pieces * price;
        document.getElementById("price" + id.substring(5)).value = new_price.toFixed(2);
    }
        
    
}

for(let i = 0 ; i < PRICES.length ; i++){
    document.getElementById("piece" + i).value = 1;
    document.getElementById("piece" + i).placeholder = 1;
    document.getElementById("price" + i).value = PRICES[i].toFixed(2);
    document.getElementById("price" + i).placeholder = PRICES[i].toFixed(2);
    document.getElementById("piece" + i).addEventListener("change",piecesToPrice);
}













let carts = document.querySelectorAll('.add_btn');

let buttons = document.querySelectorAll('.add_btn');
// console.log(buttons);
let breadCounterForIcon = JSON.parse(localStorage.getItem('counterTotal'));
let cartIcon = document.getElementById('cartIconTopRightQuantity');
console.log(cartIcon);
cartIcon.innerHTML = breadCounterForIcon;


buttons.forEach(element => {
    buttons = element.id;
    // console.log(buttons);
});
localStorage.setItem('counterTotal', breadCounterForIcon);


if(document.querySelector('.menu') !== null) 
{
let theWholeMenuPage = document.querySelector('.menu');
theWholeMenuPage.addEventListener('click', addBread);
}

function addBread (e)
{
    
    // console.log(e.target);
    if(e.target.className === 'add_btn')
    {   
        breadCounterForIcon++;
        document.getElementById('cartIconTopRightQuantity').innerHTML = breadCounterForIcon;
        localStorage.setItem('counterTotal', breadCounterForIcon);

        let theItem = e.target.id;
        console.log(theItem);
        let theItemName = theItem.substring(3);
        console.log(theItemName);
        for(let i = 0; i < menuBreadArray.length ; i++)
        {
            if(theItemName === menuBreadArray[i].name)
            {
                menuBreadArray[i].quantity++;
                console.log(menuBreadArray[i].quantity);
            }
        }

        updateLocalStorage();
    }
}
let menuBreadArray = [
    {name: 'AlmondCookies', quantity: 0},
    {name: 'CheeseCake', quantity: 0},
    {name: 'ChickenBiscuit', quantity: 0},
    {name: 'EggTart', quantity: 0},
    {name: 'GuavaBites', quantity: 0},
    {name: 'CoconutMochi', quantity: 0},
    {name: 'PineappleBites',quantity: 0},
    {name: 'PineappleCake',quantity: 0},
    {name: 'TanWongSu',quantity: 0},
    {name: 'PorkBuns',quantity: 0},
    {name: 'RedBeanPaste',quantity: 0},
    {name: 'Coconut',quantity: 0},
    {name: 'Custard',quantity: 0},
]
let importLocalStorage = JSON.parse(localStorage.getItem('localStrorageCart'));
if(importLocalStorage !== null)
{
    for(let i = 0; i < 11 ; i ++)
    {
        menuBreadArray[i].quantity = importLocalStorage[i].quantity
    }
}

function updateLocalStorage()
{
    localStorage.setItem('localStrorageCart', JSON.stringify(menuBreadArray));
}






// console.log(cartIconTopRightQuantity.innerHTML);
