
let addproduct = document.getElementById("addarticle");
let allproducts = document.getElementById("products");
let addCategory = document.getElementById("addcategory");
let categories = document.getElementById("categories");
let orders = document.getElementById("orders");                          
let users = document.getElementById("users");         


let sectionAdminAddProduct = document.getElementById("adminaddproduct");
let sectionAdminAllProduct = document.getElementById("showallproducts");
let sectionAdminAddCategory = document.getElementById("adminaddcategory");
let sectionAdminAllCategories = document.getElementById("showallcategories");
let sectionAdminAllOrders = document.getElementById("showallorders");
let sectionAdminAllUsers = document.getElementById("showAdminUsers");



let sections = [sectionAdminAddProduct,sectionAdminAllProduct,sectionAdminAddCategory,sectionAdminAllCategories,sectionAdminAllUsers,sectionAdminAllOrders];         

let selecteurs = [addproduct,allproducts,addCategory,categories ,orders,users];


/*admin menu*/

/*fonction pour afficher au moins section une section si besoin */

function stillDisplayone()
{
    var checker = 0;
    
      for (let i = 0; i < sections.length; i++) {
          
             if(sections[i].style.display === "none"){
                 checker ++ ;
             }
             
        }

        if(checker === sections.length){
    
            sectionAdminAddProduct.style.display = "flex";
            addproduct.style.color = "red";
        }    
    
}

if(addproduct !== null){
    
    sectionAdminAddProduct.style.display = "flex";
    addproduct.style.color = "red";
    
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
       
    }else{
        sectionAdminAddProduct.style.display = "none";
        addproduct.style.color = "blue";
        stillDisplayone();
    }

    
    })
}


if(allproducts !== null){
    sectionAdminAllProduct.style.display = "none";
    allproducts.style.color = "blue";
    
    allproducts.addEventListener('click', function(e){
   
    if (sectionAdminAllProduct.style.display === "none"){
         
        for (let i = 0; i < sections.length; i++) {
             sections[i].style.display = "none";
        }
        
        for (let i = 0; i < selecteurs.length; i++) {
            
             selecteurs[i].style.color = "blue";
        }
        
        sectionAdminAllProduct.style.display = "flex";
        allproducts.style.color = "red";
       
    }else{
    sectionAdminAllProduct.style.display = "none";
       allproducts .style.color = "blue";
       stillDisplayone();
    }
    
    })
}



if(addCategory !== null){
   
    sectionAdminAddCategory.style.display = "none";
    addCategory.style.color = "blue";
    
    addCategory.addEventListener('click', function(e){
        
    if (sectionAdminAddCategory.style.display === "none"){
        
       for (let i = 0; i < sections.length; i++) {
             sections[i].style.display = "none";
        }
        
        for (let i = 0; i < selecteurs.length; i++) {
            
             selecteurs[i].style.color = "blue";
        }
        
        sectionAdminAddCategory.style.display = "flex";
        addCategory.style.color = "red";
       
     } else{
        sectionAdminAddCategory.style.display = "none";
        addCategory .style.color = "blue";
        stillDisplayone()
    }
    
    })
}



if(categories !== null){
    sectionAdminAllCategories.style.display = "none";
    categories.style.color = "blue";
    
    categories.addEventListener('click', function(e){
     if (sectionAdminAllCategories.style.display === "none"){
        
       for (let i = 0; i < sections.length; i++) {
             sections[i].style.display = "none";
        }
        
        for (let i = 0; i < selecteurs.length; i++) {
            
             selecteurs[i].style.color = "blue";
        }
        
        sectionAdminAllCategories.style.display = "flex";
        categories.style.color = "red";
       
     }else{
        sectionAdminAllCategories.style.display = "none";
        categories .style.color = "blue";
        stillDisplayone()
    }
   
})
}



if(orders !== null){
    
    sectionAdminAllOrders.style.display = "none";
    orders.style.color = "blue";
    
    orders.addEventListener('click', function(e){
        
   if (sectionAdminAllOrders.style.display === "none"){
        
       for (let i = 0; i < sections.length; i++) {
             sections[i].style.display = "none";
        }
        
        for (let i = 0; i < selecteurs.length; i++) {
            
             selecteurs[i].style.color = "blue";
        }
        
        sectionAdminAllOrders.style.display = "flex";
        orders.style.color = "red";
       
     }else{
        sectionAdminAllOrders.style.display = "none";
        orders .style.color = "blue";
        stillDisplayone();
    }
   
})
}

if(users !== null){
    
    sectionAdminAllUsers.style.display = "none";
    users.style.color = "blue";
    
    users.addEventListener('click', function(e){
        
   if (sectionAdminAllUsers.style.display === "none"){
        
       for (let i = 0; i < sections.length; i++) {
             sections[i].style.display = "none";
        }
        
        for (let i = 0; i < selecteurs.length; i++) {
            
             selecteurs[i].style.color = "blue";
        }
        
       sectionAdminAllUsers.style.display = "flex";
        users.style.color = "red";
       
     }else{
        sectionAdminAllUsers.style.display = "none";
        users .style.color = "blue";
        stillDisplayone();
    }
   
})
}


