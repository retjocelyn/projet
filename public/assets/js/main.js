/*section passe en display none*/ 



let profil= document.getElementById("userprofil");
let portefeuille= document.getElementById("userwallet");
let addproduct = document.getElementById("addarticle");
let products = document.getElementById("products");
let addCategory = document.getElementById("addcategory");
let categories = document.getElementById("categories");
let orders = document.getElementById("orders");                          
let users = document.getElementById("users");                                       
                            
                            

let sectionProfil = document.getElementById("displayuserprofil");
let sectionPortefeuille = document.getElementById("displayuserwallet");
let  sectionAdminAddProduct = document.getElementById("adminaddproduct");




function showHide(a){
    a.classList.toggle("hide");
}

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

if(addproduct!== null){
    
    addproduct.addEventListener('click', function(e){
        
    showHide(sectionAdminAddProduct);
    selected(addproduct);
   
    
})
}


