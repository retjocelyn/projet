/*section passe en display none*/ 


let profil = document.getElementsByClassName("display_profil")[0]; 
let portefeuille = document.getElementsByClassName("display_wallet")[0];;


let sectionProfil = document.getElementsByClassName("showprofil")[0];
let sectionPortefeuille = document.getElementsByClassName("showwallet")[0];


function showHide(a){
    a.classList.toggle("hide");
}

function selected(a){
    a.classList.toggle("selection");
}

showHide(sectionPortefeuille);

selected(profil);


profil.addEventListener('click', function(e){
    
    showHide(sectionProfil);
    selected(profil);
    showHide(sectionPortefeuille);
    selected(portefeuille);
    
})

portefeuille.addEventListener('click', function(e){
    
    showHide(sectionPortefeuille);
    showHide(sectionProfil);
    selected(profil);
    selected(portefeuille);
    
})




