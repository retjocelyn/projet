
let addProduct = document.getElementById("addarticle");
let allProducts = document.getElementById("products");
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

let selecteurs = [addProduct,allProducts,addCategory,categories ,orders,users];


/*admin menu*/

/*fonction pour afficher au moins section une section si besoin */

const stillDisplayOne = () => {
    const noSectionDisplayed = sections.every(section => section.style.display === "none");

    if(noSectionDisplayed){
      sectionAdminAddProduct.style.display = "flex";
      addProduct.style.color = "red";
    }
} 


const eventListenerBuilder = (section, button) => (e) => {
  if (section.style.display === "none"){
          
    for (let i = 0; i < sections.length; i++) {
      sections[i].style.display = "none";
    }
    
    for (let i = 0; i < selecteurs.length; i++) {
      selecteurs[i].style.color = "blue";
    }
    
    section.style.display = "flex";
    button.style.color = "red"; 
  
  }
  else {
    section.style.display = "none";
    button.style.color = "blue";
    stillDisplayOne();
  }
}


if(addProduct !== null){
    
    sectionAdminAddProduct.style.display = "flex";
    addProduct.style.color = "red";
    
    addProduct.addEventListener('click', eventListenerBuilder(sectionAdminAddProduct,addProduct));
}


if(allProducts !== null){
    sectionAdminAllProduct.style.display = "none";
    allProducts.style.color = "blue";

    allProducts.addEventListener('click', eventListenerBuilder(sectionAdminAllProduct,allProducts));
    
}



if(addCategory !== null){
   
    sectionAdminAddCategory.style.display = "none";
    addCategory.style.color = "blue";
    
    addCategory.addEventListener('click', eventListenerBuilder(sectionAdminAddCategory,addCategory));
}    



if(categories !== null){
    sectionAdminAllCategories.style.display = "none";
    categories.style.color = "blue";
   
    categories.addEventListener('click', eventListenerBuilder(sectionAdminAllCategories,categories)); 

}


if(orders !== null){
    
    sectionAdminAllOrders.style.display = "none";
    orders.style.color = "blue";
    
    orders.addEventListener('click', eventListenerBuilder(sectionAdminAllOrders,orders)); 
}    


if(users !== null){
    
    sectionAdminAllUsers.style.display = "none";
    users.style.color = "blue";
    
    users.addEventListener('click', eventListenerBuilder(sectionAdminAllUsers,users)); 
}    

