//to ensure only one shipping method can be chosen
$('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
});

//show shipping info when free delivery is chosen
function delivery() {
  var checkBox = document.getElementById("fd");
  var text = document.getElementById("delivery");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}

//auto fill shipping address when same as billing is checked
function addressFunction() { 
     if (document.getElementById("same").checked) { 
        document.getElementById("sAddr").value = document.getElementById("bAddr").value; 
    } else { 
		document.getElementById("bAddr").value = ""; 

	} 
} 

//to validate user information before checking out
// import {checkdistance} from './map.js';

function validate() {
	
	let valid = true;
	
	let addr = document.getElementById("sAddr").value;
	var far = new checkdistance(addr);
	


	var name = document.getElementById("name").value;
    var creditCard = document.getElementById("creditCard").value;
	var cardregex = /\d{12}/;
	var cvv = document.getElementById("cvv").value;
	var expMonth = document.getElementById("expMonth").value;
	var expYear = document.getElementById("expYear").value;
	var bAddr = document.getElementById("bAddr").value;
	var sAddr = document.getElementById("sAddr").value;

	
	if (name === "" || name == null)
		valid = false;
	if (!cardregex.test(creditCard) || creditCard == null)
		valid = false;
	if (cvv === "" || cvv == null)
		valid = false;
	if (expMonth > 12 || expMonth < 1 || expMonth == null)
		valid = false;
	if (expYear === "" || expYear == null)
		valid = false;
	if (bAddr === "" || bAddr == null)
		valid = false;
	if (sAddr === "" || sAddr == null)
		valid = false;
	if (far == false)
		valid = false;
		
	if (valid == false)
		document.getElementById("error").innerHTML = "Please check if information is right";
	else
		$("checkoutForm").submit();

}

function checkdistance() {
    let addr = document.getElementById("address").value;

    var xmlhttp = new XMLHttpRequest();
    var url = "https://nominatim.openstreetmap.org/search/" + addr + "?format=json&polygon=1&addressdetails=1";
    xmlhttp.open("GET", url, true);
    xmlhttp.send();


    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myArr = JSON.parse(this.responseText);
            try {
                console.log(myArr[0])
                console.log(myArr[0].lat)
                console.log(myArr[0].lon)
                var latlng = L.latLng(45.4946892273468, -73.57733836660222);
				
                // unit meter
                let distance = latlng.distanceTo(L.latLng(parseFloat(myArr[0].lat), parseFloat(myArr[0].lon)));
                let km = (distance / 1000);
                console.log(km);
				
				if(km > 5 && document.getElementById("deliveryType").value == "delivery") {
					console.log("Distance is: " + km);
					alert("The address is not within our delivery range. We apologize for the inconvenience. Your order must be picked up");
					document.getElementById("deliveryType").value = "pickup";
				}

			} catch (e) {

            }
        };

    }
}


document.getElementById("address").addEventListener("change", checkdistance);



