const searchByTagSelector = document.querySelector('[name="search_by_tags"]')

// fonction de callback: fonction exécuter après ou dans une fonction
// fonction anonyme: fonction qui n'a pas de nom
searchByTagSelector.addEventListener('change', (event) => {
    // this fait référence à la fonction (certainement)
    //document.location = '/annonce-by-tag/' + event.target.value
    // backtick = alt gr + 7
    document.location = `/annonce-by-tag/${event.target.value}` 
})

/*searchByTagSelector.addEventListener('change', function() {
    // this fait référence à l'élément HTML
    console.log(this.value)
})*/