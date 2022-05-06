


/*partie qui gere le ajax pour barre de recherche dans home*/

let input = document.getElementById('search');
let search = document.getElementById('list-search');

if(input){
    input.addEventListener('keyup', (e) => {
        let value = e.target.value
        removeOldList()
        query(value)
        .then(data => data.json())
        .then(data => {
            if(value !== ""){
                for(let i = 0; i < data.length; i++){
                    let li = document.createElement('li');
                    search.appendChild(li);
                    li.innerHTML = `<a href="https://jocelynretiere.sites.3wa.io/projetdefindanneevraie/index.php?url=showoneproduct&id=${data[i].id}">${data[i].name}</a>`
                }
            }
        })
        
    })
}

const query = async (value) => {
    return await fetch(`https://jocelynretiere.sites.3wa.io/projetdefindanneevraie/index.php?url=search&q=${value}`);
}

function removeOldList() {
    let listItem = search.children
    
    for(let i = listItem.length - 1; i >= 0; i--){
        listItem[i].remove();
    }
}
