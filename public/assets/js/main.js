/*section passe en display none*/ 

/*les slecteurs de munu pour admin et users*/

let profil= document.getElementById("userprofil");
let portefeuille= document.getElementById("userwallet");

let addproduct = document.getElementById("addarticle");
let allproducts = document.getElementById("products");
let addCategory = document.getElementById("addcategory");
let categories = document.getElementById("categories");
let orders = document.getElementById("orders");                          
let users = document.getElementById("users");                                       
                            
                            
/*section qui vont apparaitres ou disparaitres selon les selecteurs choisis*/

let sectionProfil = document.getElementById("displayuserprofil");
let sectionPortefeuille = document.getElementById("displayuserwallet");
let sectionAdminAddProduct = document.getElementById("adminaddproduct");
let sectionAdminAllProduct = document.getElementById("showallproducts");
let sectionAdminAddCategory = document.getElementById("adminaddcategory");
let sectionAdminAllCategories = document.getElementById("showallcategories");
let sectionAdminAllOrders = document.getElementById("showallorders");

let checkbutton = document.getElementsByClassName("checkbutton")[0];             



/*fonction pour faire apparaitre ou disparaitre une section*/

function showHide(a){
    a.classList.toggle("hide");
}


/*montre quel selecteur a ete choisis*/

function selected(a){
    a.classList.toggle("selection");
}


/*user menu*/

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

/*admin menu*/

if(addproduct !== null){
    selected(addproduct);
    addproduct.addEventListener('click', function(e){
        
    showHide(sectionAdminAddProduct);
    selected(addproduct);
    
    
})
}

if(allproducts !== null){
    showHide(sectionAdminAllProduct);
    allproducts.addEventListener('click', function(e){
        
    showHide(sectionAdminAllProduct);
    selected(allproducts);
    
    
    
})
}

if(addCategory !== null){
    showHide(sectionAdminAddCategory);
    
    addCategory.addEventListener('click', function(e){
        
    showHide(sectionAdminAddCategory);
    selected(addCategory);
   
})
}



if(categories !== null){
    showHide(sectionAdminAllCategories);
    
    categories.addEventListener('click', function(e){
        
    showHide(sectionAdminAllCategories);
    selected(categories);
   
})
}



if(orders !== null){
    showHide(sectionAdminAllOrders);
    
    orders.addEventListener('click', function(e){
        
    showHide(sectionAdminAllOrders);
    selected(orders);
   
})
}

function confirm_delete() {
  return confirm('effectuer cette action?');
}