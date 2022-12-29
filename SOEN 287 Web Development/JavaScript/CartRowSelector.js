// File Description: finds all alternate rows and assigns a new class to them.
// Last Edited By: Sobhan
// Edit Date: 06-Dec-2020
// Edit #: 1
// Edit details: Created file.

let rows = document.querySelectorAll(".cartRow");

for(let i = 0 ; i < rows.length ; i++){
    if(i % 2 == 0)
        rows[i].classList.add("alt_row");
}