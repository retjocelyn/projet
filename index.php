<?php
// Router
session_start();

require_once './controller/HomeController.php';
require_once './controller/UserController.php';
require_once './controller/ProductController.php';
require_once './controller/AdminController.php';

$url = isset($_GET['url']) ? $_GET['url'] : "home"; 

switch($url){
    // Route index.php?url=home
    case "home" : 
        $homeController = new HomeController();
        $homeController->home();
        break;
        
     case "login":
        $userController = new UserController();
        $userController->login();
        break;

    case "loginSecurity":
        $userController = new UserController();
        $userController->loginSecurity();
        break;
    
    case "registerSecurity":
        $userController = new UserController();
        $userController->registerSecurity();
        break;
    
    case "register":
        $userController = new UserController();
        $userController->register();
        break;
    
    case "registeraccepted":
        $userController = new UserController();
        $userController-> registeraccepted();
        break;
        
    case "account":
        $userController = new UserController();
        $userController->account();
        break;
        
        
     case "formmodifyuser":
        $userController = new UserController();
        $userController->formModifyUser();
        break;
        
   
    case "modifyuser":
        $userController = new UserController();
        $userController->modifyUser();
        break;
        
    case "logout":
        $userController = new UserController();
        $userController->logout();
        break;        
    
    case "shop":
        $homeController = new homeController();
        $homeController->shop();
        break;
        
    case "instruments":
        $productController = new ProductController();
        $productController->instruments();
        break;
        
     case "addBasket":
        $userController = new UserController();
        $userController->addArticle();
        break;  
        
    case "basket":
        $productController = new ProductController();
        $productController->basket();
        break;
        
     
    case "deletebasket":
        $productController = new ProductController();
        $productController->deleteBasket();
        break;
        
    case "adminaccount":
        $adminController = new AdminController();
        $adminController->adminAccount();
        break; 
        
    case "createproduct":
        $productController = new ProductController();
        $productController->createProduct();
        break;    
    
    case "formmodifyproduct":
        $productController = new ProductController();
        $productController->formModifyProduct();
        break;     
    
    case "modifyproduct":
        $productController = new ProductController();
        $productController->modifyProduct();
        break;    
        
    case "deleteproduct":
        $productController = new ProductController();
        $productController->deleteProduct();
        break;  
        
    case "createcategory":
        $productController = new ProductController();
        $productController->createCategory();
        break;
        
      
    case "formmodifycategory":
        $productController = new ProductController();
        $productController->formModifyCategory();
        break;  
        
    case "modifycategory":
        $productController = new ProductController();
        $productController->modifyCategory();
        break;  
        
    case "deletecategory":
        $productController = new ProductController();
        $productController->deleteCategory();
        break;      


    case "addarticletobasket":
        $userController = new UserController();
        $userController->addArticleToBasket();
        break;
        
    case "deleteuser":
        $userController = new UserController();
        $userController->deleteUser();
        break;
        
    case "deleteuser":
        $userController = new UserController();
        $userController->deleteUser();
        break;
        
   
    case "deletearticlefrombasket":
        $userController = new UserController();
        $userController-> deleteArticleFromBasket();
        break;
        
    case "createorder":
        $productController = new ProductController();
        $productController->createOrder();
        break;   
    
    case "orders":
        $productController = new ProductController();
        $productController->showOrders();
        break;   
        
    case "deleteorder":
        $productController = new ProductController();
        $productController->deleteOrder();
        break;    
        
    case "admindeleteorder":
        $adminController = new AdminController();
        $adminController->adminDeleteOrder();
        break; 
        
     case "admindeleteuser":
        $adminController = new AdminController();
        $adminController->adminDeleteUser();
        break;    
        
}


