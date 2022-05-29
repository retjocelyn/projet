


/*partie qui gere le ajax pour barre de recherche dans home*/

let input = document.getElementById('search');
let search = document.getElementById('list-search');

if(input){
    input.addEventListener('keyup', async (e) => {
        /*recupere valeur de l input*/
        let value = e.target.value;
        removeOldList()
        const data = await query(value)
        const res = await data.json();

        if(value !== ""){
          for(let i = 0; i < res.length; i++){
              let li = document.createElement('li');
              search.appendChild(li);
              li.innerHTML =`<a href="https://jocelynretiere.sites.3wa.io/projet-symfonie/index.php?url=showOneProduct&id=${res[i].id}">${res[i].name}</a>`
          }
      }
    })
}

const query = async (value) => {
    return await fetch(`https://jocelynretiere.sites.3wa.io/projet-symfonie/index.php?url=search&q=${value}`);
}

function removeOldList() {
    let listItem = search.children
    
    for(let i = listItem.length - 1; i >= 0; i--){
        listItem[i].remove();
    }
}
