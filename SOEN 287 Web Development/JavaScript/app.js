/*
	Last Edited By: Sobhan
	Edit Date: 07-Nov-2020
	Edit Number: 0
	Edit Details:
		To help keep track of the different versions, I'm adding this to the top of every
		file. Please update this info whenever you want to change anything. This makes it easier to
		keep track of changes/the latest version.
		Thank you!
		
*/


//GRABING VARIABLES : 
const tableBody = document.querySelector('.tableCart');

//CREATING MULTIPLE ROWS : 

//CREATING EACH HTLM ROW (empty):
let rowPanAlVaporDeChancho = document.createElement('tr');
let rowPanAlVaporDeFrejolDulce = document.createElement('tr');
let rowCakeDeQueso = document.createElement('tr');
let rowCakeDePina = document.createElement('tr');
let rowCakeDeLimon = document.createElement('tr');
let rowDulceDePina = document.createElement('tr');
let rowDulceDeGuayaba = document.createElement('tr');
let rowTartaDeHuevo = document.createElement('tr');
let rowTauSaPen = document.createElement('tr');
let rowGalletasDeAlmendra = document.createElement('tr');

//REAL BREAD ARRAY :
let Bread = [
  {row : rowPanAlVaporDeChancho, name: "Pan al vapor de Chancho", className: "PanAlVaporDeChancho", quantity : 1 ,price: 0.99},
  {row : rowPanAlVaporDeFrejolDulce, name: "Pan al vapor de Frejol Dulce", className : "PanAlVaporDeFrejolDulce",quantity : 1, price: 0.99},
  {row: rowCakeDeQueso, name: "Cake de Queso", className: "CakeDeQueso", quantity : 1, price: 1.99},
  {row : rowCakeDePina, name: "Cake de Pina", className: "CakeDePina", quantity : 1, price: 1.99},
  {row: rowCakeDeLimon, name: "Cake de Limon", className: "CakeDeLimon", quantity : 1, price: 1.99},
  {row: rowDulceDePina, name: "Dulce de Pina", className: "DulceDePina" , quantity : 1, price: 1.99},
  {row : rowDulceDeGuayaba, name: "Dulce de Guayaba", className: "DulceDeGuayaba" , quantity : 1, price: 1.99},
  {row : rowTartaDeHuevo, name: "Tarta de Huevo", className: "TartaDeHuevo" , quantity : 1, price: 1.99},
  {row : rowTauSaPen,name: "Tau Sa Pen", className: "TauSaPen" , quantity : 1, price: 1.99},
  {row : rowGalletasDeAlmendra, name: "Galletas de Almendras", className: "GalletasDeAlmendra", quantity : 1, price: 1.99},
]

for(let i = 0; i < 10; i++)
{

//SETTING ROW CLASS NAME : 
Bread[i].row.className = "row"+Bread[i].className;

//DECLARING ROW VARIABLES : 
  let itemName = document.createElement('td');
  let itemPrice = document.createElement('td');
  let itemQuantity = document.createElement('td');
  let deleteItem = document.createElement('a');
  let addItem = document.createElement('a');

//Add text and Class to Cells : 
  itemName.className = Bread[i].className;
  itemName.innerHTML = Bread[i].name;
  itemPrice.className = Bread[i].className+"Price";
  itemPrice.innerHTML = Bread[i].price;
  itemQuantity.className = Bread[i].className+"Quantity";
  itemQuantity.innerHTML = Bread[i].quantity;

//Create delete and add buttons :

  deleteItem.className = 'delete-item' ;
  deleteItem.innerHTML = '<button class="delete">-</button>';
  addItem.className = 'add-item';
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
};

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
    let thisRow = e.target.parentElement.parentElement;
    let targetRowClassName = e.target.parentElement.parentElement.className;
    targetRowClassName = targetRowClassName.slice(3);
    // console.log(targetRowClassName);
    for(let i = 0; i < 10; i++)
    {
      if(targetRowClassName === Bread[i].className)
      {
        Bread[i].quantity -= 1;
        if(Bread[i].quantity === 0)
        {
          confirm('Are you sure you want to delete this item ?');
          tableBody.removeChild(thisRow);
        }else{
          //  console.log('this button is the ' + i + 'th element of the table');
          //  console.log(Bread[i].className);
          let quantity = document.querySelector('.'+ Bread[i].className + 'Quantity');
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
    let thisRowClassName = e.target.parentElement.parentElement.className;
    thisRowClassName = thisRowClassName.slice(3);
    for(let i = 0; i <10 ; i ++)
    {
      if(thisRowClassName === Bread[i].className)
      {
        Bread[i].quantity += 1;
        let quantity = document.querySelector('.'+ Bread[i].className+'Quantity');
        quantity.innerHTML = Bread[i].quantity;
      }
    }
    
  }
}