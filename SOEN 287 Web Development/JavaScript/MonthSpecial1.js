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

var d = new Date();
var n = d.getMonth();
var m = d.getFullYear();
var titleText='';
var text='';
var img= '';
if(n==0){
    //January Special
    titleText='Special offer: Only until January 31st!';
    text='Pineapple Sweets on sale!!';
    image='Styles/Specials/JanuarySpecial.jpg'
}
if(n==1){
    //February Special
    titleText='Special offer: Only until the End of February!';
    text='Mooncakes on sale!';
    image='Styles/Specials/FebruarySpecial.jpg'
}
if(n==2){
    //March Special
    titleText='Special offer: Only until March 31st!';
    text='Almond cookies for any time of the day. Now on sale!';
    image='Styles/Specials/MarchSpecial.jpg'
}
if(n==3){
    //April Special
    titleText='Special offer: Only until April 30th!';
    text='Feel like some cheese cake? Good news, they are now on sale!';
    image='Styles/Specials/AprilSpecial.jpg'
}
if(n==4){
    //May Special
    titleText='Special offer: Only until May 31st!';
    text='Dumplings stuffed with pig on sale!';
    image='Styles/Specials/MaySpecial.jpg'
}
if(n==5){
    //June Special
    titleText='Special offer: Only until June 30th!';
    text='Coconut Breads on sale!';
    image='Styles/Specials/JuneSpecial.jpg'
}
if(n==6){
    //July Special
    titleText='Vacation Time!';
    text='Mabye it`s time for a little visit?';
    image='Styles/Specials/JulySpecial.jpg'
}
if(n==7){
    //August Special
    titleText='Special offer: Only until August 31st!';
    text='Moon Cookies? Anyone?';
    image='Styles/Specials/AugustSpecial.jpg'
}
if(n==8){
    //September Special
    titleText='Special offer: Only until September 30th!';
    text='September... this month we celebrate the Mid Autumn Party with the Moon Cakes, a traditional and indispensable sweet to appreciate the moon 🌙 (limited time only)';
    image='Styles/Specials/SeptemberSpecial.jpg'
}
if(n==9){
    //October Special
    titleText='Special offer: Only until October 31st!';
    text='Sweet cookies on sale waiting for you!';
    image='Styles/Specials/OctoberSpecial.jpg'
}
if(n==10){
    //November Special
    titleText='Special offer: Only until November 30th!';
    text='Lemon Cakes on sale!';
    image='Styles/Specials/NovemberSpecial.jpg'
}
if(n==11){
    //December Special
    titleText='Thank you for a wonderful '+m+'!!';
    text=''; 
    image='Styles/Specials/DecemberSpecial.jpg'
}
document.writeln(titleText)