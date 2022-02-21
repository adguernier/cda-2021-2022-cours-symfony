// input qui permet de taper l'adresse
const addressAutocompleteSelector = document.querySelector('.addressAutocomplete')
// adresse de l'API pour chercher les adresses
const apiUrl = 'https://api-adresse.data.gouv.fr/search/?q='
// la liste des résultats
const ulResult = document.querySelector('.addressAutocompleteResult')

const lonElement = document.querySelector('#annonce_address_lon')
const latElement = document.querySelector('#annonce_address_lat')
const streetElement = document.querySelector('#annonce_address_street')
const streetNumberElement = document.querySelector('#annonce_address_streetNumber')
const zipCodeElement = document.querySelector('#annonce_address_zipCode')
const cityElement = document.querySelector('#annonce_address_city')

addressAutocompleteSelector.addEventListener('keyup', (e) => {
    ulResult.innerHTML = ''
    if (e.target.value.length <= 3)
        return

    const promise = fetch(apiUrl + e.target.value)
    // la requête est asynchrone, le script est pas bloqué
    // on réagit seulement quand la promesse est terminée
    // donc quand on a une réponse de l'API
    promise.then(function(response){ // c'est JS qui envoie response
        return response.json()
    }).then(function(json) { // c'est JS qui envoie json (retourné dans la fonction d'avant)
        // faire une boucle sur json
            // pour chaque itération,
            // il faut créer un élément HTML <li>
            // et faire apparaître cet element dans un <ul>
        json.features.forEach(el => {
            const li = document.createElement('li');
            li.addEventListener('click', e => {
                addressAutocompleteSelector.value = e.target.textContent
                ulResult.innerHTML = ''
                // el correspond aux infos qu'on reçoit de l'API
                lonElement.value = el.geometry.coordinates[0]
                latElement.value = el.geometry.coordinates[1]
                streetElement.value = el.properties.name
                if (typeof el.properties.housenumber !== "undefined") {
                    streetNumberElement.value = el.properties.housenumber
                }
                zipCodeElement.value = el.properties.citycode
                cityElement.value = el.properties.city
            })
            li.textContent = el.properties.label;
            ulResult.appendChild(li);
        })
    })
})