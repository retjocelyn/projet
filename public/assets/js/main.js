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
let sectionAdminAllUsers = document.getElementById("showAdminUsers");


let sections = [sectionAdminAddProduct,sectionAdminAllProduct,sectionAdminAddCategory,sectionAdminAllCategories,sectionAdminAllUsers,sectionAdminAllOrders];         

let selecteurs = [addproduct,allproducts,addCategory,categories ,orders,users];


/*fonction pour faire apparaitre ou disparaitre une section*/

function showHide(a){
    a.classList.toggle("hide");
}


/*montre quel selecteur a ete choisis*/

function selected(a){
    a.classList.toggle("selection");
}

console.log(addproduct.style.color);
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
    showHide(sectionAdminAddProduct);
    
    addproduct.addEventListener('click', function(e){
        
     if (sectionAdminAddProduct.style.display === "none"){
         
        for (let i = 0; i < sections.length; i++) {
             sections[i].style.display = "none";
        }
        
        for (let i = 0; i < selecteurs.length; i++) {
            
             selecteurs[i].style.color = "blue";
        }
        
        sectionAdminAddProduct.style.display = "flex";
        addproduct.style.color = "red";
       
    } else{
        sectionAdminAddProduct.style.display = "none";
        addproduct.style.color = "blue";
    }

    
    })
}


if(allproducts !== null){
    showHide(sectionAdminAllProduct);
    allproducts.addEventListener('click', function(e){
        
    showHide(sectionAdminAllProduct);
    selected(allproducts);
    
    
    
})
}

console.log(sectionAdminAddProduct.style.display);

if(addCategory !== null){
    showHide(sectionAdminAddCategory);
    
    addCategory.addEventListener('click', function(e){
        
        if(sectionAdminAddCategory.style.display === "block"){
            for (let i = 0; i < sections.length ; i++) {  
                
                if(sections[i].style.display === "block"){
                    showHide(sections[i]);
                }
            }
            
            selected(addCategory);
        }else{
             for (let i = 0; i < sections.length ; i++) {  
                
                if(sections[i].style.display === "block"){
                    showHide(sections[i]);
                }
            }
            showHide(sectionAdminAddCategory);
            selected(addCategory);
        }    
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
  return confirm('Effectuer cette action ?');
}






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
                li.innerHTML = `<a href="https://jocelynretiere.sites.3wa.io/projet-de%20-fin-d'ann%C3%A9e/index.php?url=showoneproduct&id=${data[i].id}">${data[i].name}</a>`
            }
        }
    })
    
})
}
const query = async (value) => {
    return await fetch(`https://jocelynretiere.sites.3wa.io/projet-de%20-fin-d'ann%C3%A9e/index.php?url=search&q=${value}`);
}

function removeOldList() {
    let listItem = search.children
    
    for(let i = listItem.length - 1; i >= 0; i--){
        listItem[i].remove();
    }
}
