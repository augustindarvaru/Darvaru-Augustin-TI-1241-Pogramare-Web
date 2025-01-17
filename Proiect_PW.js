// Cheia API Google Maps
const API_KEY = "AIzaSyCNK8EVy8T-hBTciRpQyV0vY7pM52c20_c";

// Funcție pentru inițializarea hărții Google Maps
function initMap() {
    // Coordonatele locației exacte
    const location = { lat: 46.4592, lng: 26.8026 };

    // Inițializarea hărții
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location,
    });

    // Adăugăm un marker pe locație
    new google.maps.Marker({
        position: location,
        map: map,
        title: "Teren Plantație de Trufe",
    });
}

// Adăugarea dinamică a scriptului pentru Google Maps
const script = document.createElement("script");
script.src = `https://maps.googleapis.com/maps/api/js?key=${API_KEY}&callback=initMap`;
script.async = true;
script.defer = true;
document.head.appendChild(script);
