const addressAutocompleteSelector = document.querySelector('.addressAutocomplete')
const apiUrl = 'https://api-adresse.data.gouv.fr/search/?q='
const ulResult = document.querySelector('.addressAutocompleteResult')

addressAutocompleteSelector.addEventListener('keyup', (e) => {
    ulResult.innerHTML = ''
    console.log(e.target.value.length <= 3)
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
            li.textContent = el.properties.label;
            ulResult.appendChild(li);
        })
    })

    /*promise
        .then(response => response.json())
        .then(json => console.log(json))*/
})