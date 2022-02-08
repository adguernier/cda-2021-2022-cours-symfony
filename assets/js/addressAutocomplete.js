const addressAutocompleteSelector = document.querySelector('.addressAutocomplete')
const apiUrl = 'https://api-adresse.data.gouv.fr/search/?q='

const addresses = [
    {
        'street': 'rue de machin',
        'number': 2
    }, 
    {
        'street': 'rue de truc',
        'number': 4
    }
]

addresses.forEach(el => {
    const p = document.createElement('p')
    p.classList.add('test')
    p.innerText = el.street
    p.addEventListener('click', e => {
        console.log('click')
    })

    addressAutocompleteSelector.after(p)
})


addressAutocompleteSelector.addEventListener('keyup', (e) => {
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
    })

    /*promise
        .then(response => response.json())
        .then(json => console.log(json))*/
})