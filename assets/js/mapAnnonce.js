import '../../node_modules/leaflet/dist/leaflet.css'

import L from 'Leaflet'

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
    iconUrl: require("leaflet/dist/images/marker-icon.png"),
    shadowUrl: require("leaflet/dist/images/marker-shadow.png")
});

const baseLat = 48.8574776804027
const baseLng = 2.289697034198719
const map = L.map('map').setView([baseLat, baseLng], 13)
const localizeMeEl = document.querySelector('#localizeMe')
let userMarker = L.marker([baseLat, baseLng]).addTo(map)

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// au chargment de la page
localizeMe()

localizeMeEl.addEventListener('click', e => {
    localizeMe()
})

function localizeMe() {
    if ("geolocation" in navigator) {
        // demande à l'utilisateur sa position
        navigator.geolocation.getCurrentPosition(position => {
            map.setView([position.coords.latitude, position.coords.longitude], 13)
            userMarker.setLatLng(L.latLng(position.coords.latitude, position.coords.longitude))
            userMarker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup()
        });
    }
}