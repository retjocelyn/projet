/*section passe en display none*/ 

/*les selecteurs de munu pour admin et users*/
let profil= document.getElementById("userprofil");
let portefeuille= document.getElementById("userwallet");

                        
/*section qui vont apparaitres ou disparaitres selon les selecteurs choisis*/

let sectionProfil = document.getElementById("displayuserprofil");
let sectionPortefeuille = document.getElementById("displayuserwallet");


function showHide(a){
    a.classList.toggle("hide");
}


/*montre quel selecteur a ete choisis*/

function selected(a){
    a.classList.toggle("selection");
}


if(profil !== null){
    selected(profil);
    profil.addEventListener('click', function(e){
        
        showHide(sectionProfil);
        selected(profil);
        
        showHide(sectionPortefeuille);
        selected(portefeuille);
        
    })
}


if(portefeuille !== null){
    
    showHide(sectionPortefeuille);
    portefeuille.addEventListener('click', function(e){
    
    showHide(sectionPortefeuille);
    showHide(sectionProfil);
    
    selected(profil);
    selected(portefeuille);
    
    })
}    