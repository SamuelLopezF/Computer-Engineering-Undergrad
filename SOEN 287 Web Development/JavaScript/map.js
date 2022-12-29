var mymap = L.map('mapid').setView([-2.195611, -79.884254], 14);
/*
var circle = L.circle([-2.195611, -79.884254], {
    color: 'green',
    fillColor: 'LightGreen',
    fillOpacity: 0.5,
    radius: 500
}).addTo(mymap);
*/
var circle = L.marker([-2.195611, -79.884254], {
    color: 'green',
    fillColor: 'LightGreen',
    fillOpacity: 0.5,
    radius: 20
}).addTo(mymap);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <ahref="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, '
        + '<a href="https://creativecommons.org/licenses/bysa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <ahref="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1
}).addTo(mymap);


let button = document.getElementById("submit");
button.onclick = function () {
    let addr = document.getElementById("searchAddress").value;


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
                document.getElementById("lattitude").value = myArr[0].lat;
                document.getElementById("Longitude").value = myArr[0].lon;
                var latlng = L.latLng(-2.195611, -79.884254);

                // unit meter
                let distance = latlng.distanceTo(L.latLng(parseFloat(myArr[0].lat), parseFloat(myArr[0].lon)));
                let km = (distance / 1000).toFixed(2);
                console.log(km)
                document.getElementById("distance").innerHTML = km;

                L.polyline([[-2.195611, -79.884254], [myArr[0].lat, myArr[0].lon]],{color:'green'}).addTo(mymap).bindPopup(km+"km");

                console.log()
				var circle = L.circle([myArr[0].lat, myArr[0].lon], {
					color: 'red',
					fillColor: '#FFF0F5',
					fillOpacity: 0.5,
					radius: 20
					}).addTo(mymap);
            } catch (e) {

            }
        };

    }
}


