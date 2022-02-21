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
const apiUrl = '/api/annonce/search-by-position'

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
            centerMap(position)
            searchAddress(position)
        });
    }
}

function centerMap(position) {
    map.setView([position.coords.latitude, position.coords.longitude], 13)
    userMarker.setLatLng(L.latLng(position.coords.latitude, position.coords.longitude))
    userMarker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup()
    L.circle([position.coords.latitude, position.coords.longitude], {
        color: 'blue',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 5000
    }).addTo(map);
}

function searchAddress(position) {
    const promise = fetch(apiUrl + '?lat='+position.coords.latitude+'&lon='+position.coords.longitude+'&radius=50')
    promise.then(response => response.json())
    .then(json => {
        json.forEach(address => {
            let html = ''
            address.annonce.forEach(annonce => {
                html += '<p><a href="/annonce/'+annonce.id+'">'+annonce.title+' ('+annonce.price+'€)</a></p>'
            });
            
            const marker = L.marker([address.lat, address.lon]).addTo(map).bindPopup(html)
        });
    })
}


document.querySelector('#localizeByAddress').addEventListener('keyup', (e) => {
    const ulResult = document.querySelector('#localizeByAddressResult')
    const input = e.target
    ulResult.innerHTML = ''
    if (e.target.value.length <= 3)
        return

    const promise = fetch('https://api-adresse.data.gouv.fr/search/?q=' + e.target.value)
    promise.then(function(response){ 
        return response.json()
    }).then(function(json) {
        json.features.forEach(el => {
            const li = document.createElement('li');
            li.addEventListener('click', e => {
                input.value = e.target.textContent
                ulResult.innerHTML = ''
                const position = {
                    coords: {
                        latitude: el.geometry.coordinates[1],
                        longitude: el.geometry.coordinates[0]
                    }
                }
                centerMap(position)
                searchAddress(position)
            })
            li.textContent = el.properties.label;
            ulResult.appendChild(li);
        })
    })
})
