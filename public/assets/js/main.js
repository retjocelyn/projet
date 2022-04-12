/*section passe en display none*/ 


let profil = document.getElementsByClassName("display_profil")[0]; 
let portefeuille = document.getElementsByClassName("display_wallet")[0];;


let sectionProfil = document.getElementsByClassName("showprofil")[0];
let sectionPortefeuille = document.getElementsByClassName("showwallet")[0];

relou(sectionPortefeuille);


function relou(a){
    a.classList.toggle("hide");
}

profil.addEventListener('click', function(e) {
    relou(sectionProfil);
    
})

portefeuille.addEventListener('click', function(e) {
    relou(sectionPortefeuille);
})




