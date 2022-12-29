let items = document.querySelectorAll(".menuItem");
let filters = document.querySelectorAll(".filter");
let row = document.getElementById("row1");
let button = document.getElementById("filter_button");
let currentRow = 1;
const MAX_ROW = 6;

function updateRow(){
    row = document.getElementById("row" + ++currentRow);
}

function resetRow(){
    currentRow = 1;
    row = document.getElementById("row1");
}

function removeAll(){
    let current = document.querySelectorAll(".menuItem");
    // for each item currently existing
    for (let i = 0 ; i < current.length ; i++){
        // check each row for it, and remove it if it;s in that row
        for(let j = 1 ; j < MAX_ROW ; j++){
            if(row.contains(current[i])){
                row.removeChild(current[i]);
                break;
            }
            else
                updateRow();   
        }
        resetRow();
    }
}

function findFilters(){
    let filter = new Array;
    // if filter is checked, adding to the list of current filters and return
    for(let i = 0 ; i < filters.length ; i++){
        if(filters[i].checked == true)
            filter.push(filters[i].value);
    }
    return filter;
}

function insertFilter(){
    let filter = findFilters();
    let count = 0;
    removeAll();

    // check each item against each currently active filter and insert it
    // if it has the appropriate class
    for(let i = 0 ; i < items.length ; i++){
        for(let j = 0 ; j < filter.length ; j++){
            if(items[i].classList.contains(filter[j])){
                row.appendChild(items[i]);
                // makes sure each row only has 3 items
                if (++count == 3){
                    updateRow();
                    count = 0;
                }
                    
                break;
            }
        }
    }

    resetRow();
}

button.addEventListener("click", insertFilter);

insertFilter();
