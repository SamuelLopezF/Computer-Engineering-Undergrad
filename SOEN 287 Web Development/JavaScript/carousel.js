//  File Description: Carousel in Home Page
// 	Last Edited By: Sobhan
// 	Edit Date: 24-Nov-2020
// 	Edit Number: 2
// 	Edit Details:
//      Updated to make everything entirely reliable on the three constants

const NUM_OF_PICS = 3;
const INTERVAL = 10; //INTERVAL/10 = seconds (default 1 second) it takes to fade
const WAIT = 2000; // How long to pause on each image (in ms)
let current = 0;
let fadeOutTimeout = 0;
let fadeInTimeout = 0;
let transitionTimeout = 0;
let timeout0 = 0;
let timeout1 = 0;
let timeout2 = 0;
let timeout3 = 0;
let gallery = document.getElementById("carousel");
let nextImg = document.getElementById("next");
let prevImg = document.getElementById("prev");

function transition(){
    clearAllTimeout();
    // Wait 5 seconds then fade current image out;
    timeout0 = setTimeout(fadeOut,WAIT);
    // swap after fading out
    timeout1 = setTimeout(function(){
        current = (((current + 1) % NUM_OF_PICS) + NUM_OF_PICS) % NUM_OF_PICS;
        swapImage(current);
    }, WAIT + 100*INTERVAL);
    // fade in
    timeout2 = setTimeout(fadeIn, WAIT + 100*INTERVAL);
    // repeat after fading in
    timeout3 = setTimeout(transition, WAIT + 200*INTERVAL);
}

function fadeOut(){
    clearTimeout(fadeInTimeout);
    // decrease opacity
    gallery.style.opacity = (parseFloat(gallery.style.opacity) - 0.01).toString();
    // check whether to repeat or not
    if (parseFloat(gallery.style.opacity) > 0)
        fadeOutTimeout = setTimeout(fadeOut, INTERVAL);
    else
        gallery.style.opacity = "0";
}

function fadeIn(){
    clearTimeout(fadeOutTimeout);
    // increase opacity
    gallery.style.opacity = (parseFloat(gallery.style.opacity) + 0.01).toString();
    // check whether to repeat or not
    if (parseFloat(gallery.style.opacity) < 1)
        fadeInTimeout = setTimeout(fadeIn, INTERVAL);
    else
        gallery.style.opacity = "1";
}

// swap to given img in carousel
function swapImage(num){
    gallery.src = "Styles/Carousel/" + num + ".jpg";
}

// clears all timeouts and makes img opaque
function clearAllTimeout(){
    clearTimeout(timeout0);
    clearTimeout(timeout1);
    clearTimeout(timeout2);
    clearTimeout(timeout3);
    clearTimeout(fadeInTimeout);
    clearTimeout(fadeOutTimeout);
    clearTimeout(transitionTimeout);
    gallery.style.opacity = "1";
}

// goes to next img and begins transition process
nextImg.addEventListener("click", function(){
    clearAllTimeout();
    current = (((current + 1) % NUM_OF_PICS) + NUM_OF_PICS) % NUM_OF_PICS;
    swapImage(current);
    transitionTimeout = setTimeout(transition, 10);
});

// goes to previous img and begins transition process
prevImg.addEventListener("click", function(){
        clearAllTimeout();
        current = (((current - 1) % NUM_OF_PICS) + NUM_OF_PICS) % NUM_OF_PICS;
        swapImage(current);
        transitionTimeout = setTimeout(transition, 10);
});

// start transition when mouse out
gallery.addEventListener("mouseout", function(){
    clearAllTimeout();
    transitionTimeout = setTimeout(transition, 10);
});

// pause everything when mouse is on img
gallery.addEventListener("mouseover", clearAllTimeout);

transition();
