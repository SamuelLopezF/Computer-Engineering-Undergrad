/*
  File Description: I don't know
	Last Edited By: Sobhan
	Edit Date: 07-Nov-2020
	Edit Number: 1
	Edit Details:
		To help keep track of the different versions, I'm adding this to the top of every
		file. Please update this info whenever you want to change anything. This makes it easier to
		keep track of changes/the latest version.
		Thank you!
		
*/

//ARRAYS:
let breadArray =
[
  bOne =
  {
    name: "Pork Steamed Bread",
    price: 0.8,
    reference: 1,
    quantity: 0
  },
  bTwo =
  {
    name: "Coconut Steamed Bread",
    price: 0.8,
    reference: 2,
    quantity: 0,
  },
  bThree =
  {
    name:"Sweet Bean Steamed Bread",
    price: 0.8,
    reference: 3,
    quantity: 0,
  },
  bFour =
  {
    name:"Cheese Cake",
    price: 1,
    reference: 4,
    quantity: 0,
  },
  bFive =
  {
    name:"Pineapple Cake",
    price: 1,
    reference: 5,
    quantity: 0,
  },
  bSix =
  {
    name:"Lemon",
    price: 8,
    reference: 6,
    quantity: 0,
  },
  bSeven =
  {
    name:"Pineapple Candy",
    price: 0.6,
    reference: 7,
    quantity: 0,
  },
  bEight =
  {
    name:"Guava Candy",
    price: 0.6,
    reference: 8,
    quantity: 0,
  },
  bNine =
  {
    name:"Egg Tart",
    price: 1,
    reference: 9,
    quantity: 0,
  },
  bTen =
  {
    name:"",
    price: 0,
    reference: 10,
    quantity: 0,
  },
  bEleven =
  {
    name:"Almond Cookies",
    price: 0.5,
    reference: 11,
    quantity: 0,
  },
  bTwelve =
  {
    name:"Sweet Beans",
    price: 0,
    reference: 12,
    quantity: 0,
  },
  bThirteen =
  {
    name:"Nuts",
    price: 0,
    reference: 13,
    quantity: 0,
  },
  bFourteen =
  {
    name:"Sweet Beans with Salted Egg Yolk",
    price: 0,
    reference: 14,
    quantity: 0,
  },
  bFifteen =
  {
    name:"Nuts with Salted Egg Yolk",
    price: 0,
    reference: 15,
    quantity: 0,
  }
]
const btnArray = [
  btnOne = document.querySelector(".btnOne"),
  btnTwo = document.querySelector(".btnTwo"),
]
//VARIABLES:
var total = 0;
let cartTotalPrice = 0;
const cartTable = document.querySelector(".myCartBody");
let deleteBtnTwo;
//FUNCTIONS:
//ADD A SPECIFIC BREAD
function addBread (reference)
{
  cartTotalPrice = 0;
  switch (reference)
  {
    
    case 1:
    
      if(breadArray[0].quantity == 0)
      {
        let row = cartTable.insertRow();
        breadArray[0].quantity += 1;
        row.innerHTML = `<td>${breadArray[0].name}</td><td>${breadArray[0].price}</td><td class = "quantity1">${breadArray[0].quantity}</td><td><button class = "button-js-One">X<td>`;
      }

      else
      {
        breadArray[0].quantity += 1;
        printedQuantity = document.querySelector(".quantity1");
        printedQuantity.innerHTML = `${breadArray[0].quantity}`;
        // console.log(breadArray[0].quantity);
      }

      // cartTotal();
      break;

    case 2:
      
      if(breadArray[1].quantity == 0)
      {
        let row = cartTable.insertRow();
        breadArray[1].quantity += 1;
        row.innerHTML = `<td>${breadArray[1].name}</td><td>${breadArray[1].price}</td><td class = "quantity2">${breadArray[1].quantity}</td><td><button class = "button-js-Two">X</button><td>`;
        deleteBtnTwo = document.querySelector(".button-js-Two");
      }

      else
      {
        breadArray[1].quantity += 1;
        printedQuantity = document.querySelector(".quantity2");
        printedQuantity.innerHTML = `${breadArray[1].quantity}`;
        // console.log(breadArray[1].quantity);
      }
      // cartTotal();
      break;
  }
  console.log(cartTotal());
}
//CALCULATE TOTAL $$:
function cartTotal()
{

      for(let i = 0; i < breadArray.length ; i++)
      {
        cartTotalPrice += (breadArray[i].quantity * breadArray[i].price);
      }
  return cartTotalPrice;
}
//DELETE BREAD:

function deleteBread(selector)
{
  switch(selector)
  {
    case 1: 
      breadArray[0].quantity -= 1;
      console.log("-", breadArray[0].quantity);
      document.querySelector(".quantity1") = breadArray[0].quantity;

    case 2: 
    breadArray[1].quantity -= 1;
    console.log(breadArray[1].quantity);
    document.querySelector(".quantity2") = breadArray[1].quantity;  
  }
}



//EVENT LISTENERS:
btnArray[0].addEventListener("click", function()
    {
      addBread(1);
    }
  );
btnArray[1].addEventListener("click", function()
    {
      addBread(2);
    }
  );
// deleteBtnOne.addEventListener("click", function()
//   {
//     deleteBread[1];
//   }
// );
// deleteBtnTwo.addEventListener("click", function()
//   {
//     deleteBread[2];
//   }
// );

