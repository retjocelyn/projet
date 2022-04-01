/*section passe en display none*/ 

let commandes = document.getElementById("orders");
let profil= document.getElementById("profil");
let portefeuille = document.getElementById("wallet");

let sectionCommandes = document.getElementsByClassName("showOrders")[0]
let sectionProfil = document.getElementsByClassName("showprofil")[0]
let sectionPortefeuille = document.getElementsByClassName("showwallet")[0]

sectionPortefeuille.style.display = "none";
sectionCommandes.style.display = "none";
profil.style.backgroundColor = "red";


profil.addEventListener('click', function(e) {
     if (sectionProfil.style.display === "none"){
        sectionProfil.style.display = "block";
        sectionCommandes.style.display = "none";
        sectionPortefeuille.style.display = "none";
        profil.style.backgroundColor = "red";
        portefeuille.style.backgroundColor = "white";
        commandes.style.backgroundColor = "white";
    } else{
        sectionProfil.style.display = "none";
        profil.style.backgroundColor = "white";
    }
})
portefeuille.addEventListener('click', function(e) {
     if (sectionPortefeuille.style.display === "none"){
        sectionPortefeuille.style.display = "block";
        sectionCommandes.style.display = "none";
        sectionProfil.style.display = "none";
        profil.style.backgroundColor = "white";
        commandes.style.backgroundColor = "white";
        portefeuille.style.backgroundColor = "red";
        
    } else{
        sectionPortefeuille.style.display = "none";
        portefeuille.style.backgroundColor = "white";
        
    }
})    
commandes.addEventListener('click', function(e) {
    if (sectionCommandes.style.display === "none"){
        sectionCommandes.style.display = "block";
        sectionProfil.style.display = "none";
        sectionPortefeuille.style.display = "none";
        profil.style.backgroundColor = "white";
        portefeuille.style.backgroundColor = "white";
        commandes.style.backgroundColor = "red";
    } else{
        sectionCommandes.style.display = "none";
        commandes.style.backgroundColor = "white";
    }
})

