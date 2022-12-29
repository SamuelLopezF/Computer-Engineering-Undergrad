//GRABING VARIABLES : 
const tableBody = document.querySelector('.tableCart');
let breadCounterForIcon = JSON.parse(localStorage.getItem('counterTotal'));
let cartIcon = document.getElementById('cartIconTopRightQuantity');

//CREATING MULTIPLE ROWS : 

//CREATING EACH HTLM ROW (empty):
let AlmondCookiesRow = document.createElement('tr');
let CheeseCakeRow = document.createElement('tr');
let ChickenBiscuitRow = document.createElement('tr');
let EggTartRow = document.createElement('tr');
let GuavaBitesRow = document.createElement('tr');
let CoconutMochiRow = document.createElement('tr');
let PineappleBitesRow = document.createElement('tr');
let PineappleCakeRow = document.createElement('tr');
let TanWongSuRow = document.createElement('tr');
let PorkBunsRow = document.createElement('tr');
let RedBeanPasteRow = document.createElement('tr');
let CoconutRow = document.createElement('tr');
let CustardRow = document.createElement('tr');

//IMPORTING LOCAL STORAGE : 
let localStorageBreadArray = JSON.parse(localStorage.getItem('localStrorageCart'));
console.log(localStorageBreadArray);

//REAL BREAD ARRAY :
let Bread = [
  {name: 'AlmondCookies', quantity: 0, row:  AlmondCookiesRow},
  {name: 'CheeseCake', quantity: 0, row: CheeseCakeRow},
  {name: 'ChickenBiscuit', quantity: 0, row: ChickenBiscuitRow},
  {name: 'EggTart', quantity: 0,row:  EggTartRow},
  {name: 'GuavaBites', quantity: 0,row: GuavaBitesRow},
  {name: 'CoconutMochi', quantity: 0, row: CoconutMochiRow},
  {name: 'PineappleBites',quantity: 0, row: PineappleBitesRow},
  {name: 'PineappleCake',quantity: 0, row:  PineappleCakeRow},
  {name: 'TanWongSu',quantity: 0, row: TanWongSuRow},
  {name: 'PorkBuns',quantity: 0, row: PorkBunsRow},
  {name: 'RedBeanPaste',quantity: 0, row: RedBeanPasteRow},
  {name: 'Coconut',quantity: 0, row: CoconutRow},
  {name: 'Custard',quantity: 0, row: CustardRow},
]

//MATCHING BREAD ARRAY WITH LOCAL  STORAGE : 
for(let i = 0 ; i < 11 ; i ++){
  
  if (localStorageBreadArray[i].quantity !== 0)
  {
    Bread[i].quantity = localStorageBreadArray[i].quantity;
  }
}

function fromArrayToLocalStorage()
{
  console.log(localStorageBreadArray);
  for(let i = 0 ; i < 11 ; i ++){
      localStorageBreadArray[i].quantity =  Bread[i].quantity;
  }
  console.log(localStorageBreadArray);
  localStorage.setItem('localStrorageCart', JSON.stringify(localStorageBreadArray))
}

function updateCart()
{
for(let i = 0; i < 11; i++)
{
    if(Bread[i].quantity !== 0)
      {
      //SETTING ROW CLASS NAME : 
      Bread[i].row.className = "row"+Bread[i].name;

      //DECLARING ROW VARIABLES : 
        let itemName = document.createElement('td');
        let itemPrice = document.createElement('td');
        let itemQuantity = document.createElement('td');
        let deleteItem = document.createElement('a');
        let addItem = document.createElement('a');

      //Add text and Class to Cells : 
        itemName.className = Bread[i].name;
        itemName.innerHTML = Bread[i].name;
        // itemPrice.className = Bread[i].name+"Price";
        // itemPrice.innerHTML = Bread[i].price;
        itemQuantity.className = Bread[i].name+"Quantity";
        itemQuantity.innerHTML = Bread[i].quantity;

      //Create delete and add buttons :

        deleteItem.className = 'delete-item' ;
        deleteItem.id = 'id' + Bread[i].name ;
        deleteItem.innerHTML = '<button class="delete">-</button>';
        addItem.className = 'add-item';
        deleteItem.id = 'id' + Bread[i].name ;
        addItem.innerHTML = '<button class="add">+</button>';

      //LINKING ELEMENTS TO ROW
        Bread[i].row.appendChild(itemName);
        Bread[i].row.appendChild(itemPrice);
        Bread[i].row.appendChild(itemQuantity);
        Bread[i].row.appendChild(addItem);
        Bread[i].row.appendChild(deleteItem);
        //ADDING TO TABLE BODY : 
      tableBody.appendChild(Bread[i].row);

      //PRINTING : 
        console.log(Bread[i].row);
        }
}
}
updateCart();
//GRABBING + & - BUTTONS :
  let buttonAdd = document.querySelectorAll('.add');
  let buttonDelete = document.querySelectorAll('.delete-item');
  console.log(buttonAdd);
  console.log(buttonDelete);



loadEventListeners();
//EVENT LISTENER : 

function loadEventListeners()
{
  tableBody.addEventListener("click", removeBread);
  tableBody.addEventListener("click", addBread);
}


function removeBread(e)
{ 
  if(e.target.parentElement.classList.contains('delete-item'))
  {
    breadCounterForIcon --;
    localStorage.setItem('counterTotal', breadCounterForIcon);
    let thisRow = e.target.parentElement.parentElement;
    cartIcon.innerHTML = breadCounterForIcon;
    


    let targetRowClassName = e.target.parentElement.parentElement.className;
    targetRowClassName = targetRowClassName.slice(3);
    console.log(targetRowClassName);
    for(let i = 0; i < 10; i++)
    {
      if(targetRowClassName === Bread[i].name)
      {

        if(Bread[i].quantity === 1)
        {
          if(confirm('Are you sure you want to delete this item ?'))
          {
            Bread[i].quantity -= 1;
            fromArrayToLocalStorage();
            tableBody.removeChild(thisRow);
            
          }else{
            continue;
          }
        }else{
          Bread[i].quantity -= 1;
          console.log('clieced it ');
          fromArrayToLocalStorage();
          //  console.log('this button is the ' + i + 'th element of the table');
          //  console.log(Bread[i].className);
          let quantity = document.querySelector('.'+ Bread[i].name + 'Quantity');
          //  console.log(quantity);
          quantity.innerHTML = Bread[i].quantity;
        }
    }
    }
  }
}

function addBread(e)
{
  if(e.target.parentElement.classList.contains('add-item'))
  {
    breadCounterForIcon ++;
    localStorage.setItem('counterTotal', breadCounterForIcon);
    cartIcon.innerHTML = breadCounterForIcon;

  
    let thisRowClassName = e.target.parentElement.parentElement.className;
    thisRowClassName = thisRowClassName.slice(3);
    for(let i = 0; i <11 ; i ++)
    {
      if(thisRowClassName === Bread[i].name)
      {
        Bread[i].quantity += 1;
        fromArrayToLocalStorage();
        let quantity = document.querySelector('.'+ Bread[i].name+'Quantity');
        quantity.innerHTML = Bread[i].quantity;

      }
    }
    
  }
}

//CHANGING ICON TEXT :

console.log(cartIcon);
cartIcon.innerHTML = breadCounterForIcon;