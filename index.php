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
    case "home": 
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
    
        
    case "registerAccepted":
        $userController = new UserController();
        $userController->registerAccepted() ;
        break;
        
        
    case "confirmationOrNot":
        $homeController = new homeController();
        $homeController->confirmationOrNot() ;
        break;
        
    case "account":
        $userController = new UserController();
        $userController->account();
        break;
        
        
     case "formModifyUser":
        $userController = new UserController();
        $userController->formModifyUser();
        break;
        
   
    case "modifyUser":
        $userController = new UserController();
        $userController->modifyUser();
        break;
        
    case "addMoney":
        $userController = new UserController();
        $userController->addMoney();
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
        
     
    case "deleteBasket":
        $userController = new UserController();
        $userController->deleteBasket();
        break; 
        
    case "adminAccount":
        $adminController = new AdminController();
        $adminController->adminAccount();
        break; 
        
    case "createProduct":
        $productController = new ProductController();
        $productController->createProduct();
        break;    
    
    case "formModifyProduct":
        $productController = new ProductController();
        $productController->formModifyProduct();
        break;     
    
    case "modifyProduct":
        $productController = new ProductController();
        $productController->modifyProduct();
        break;    
        
    case "deleteProduct":
        $productController = new ProductController();
        $productController->deleteProduct();
        break;  
        
    case "createCategory":
        $productController = new ProductController();
        $productController->createCategory();
        break;
        
      
    case "formModifyCategory":
        $productController = new ProductController();
        $productController->formModifyCategory();
        break;  
        
    case "modifyCategory":
        $productController = new ProductController();
        $productController->modifyCategory();
        break;  
        
    case "deleteCategory":
        $productController = new ProductController();
        $productController->deleteCategory();
        break;      


    case "addArticleToBasket":
        $userController = new UserController();
        $userController->addArticleToBasket();
        break;
        
    case "deleteUser":
        $userController = new UserController();
        $userController->deleteUser();
        break;
        
   
    case "deleteArticleFromBasket":
        $userController = new UserController();
        $userController->deleteArticleFromBasket();
        break;
        
    case "createOrder":
        $userController = new UserController();
        $userController->createOrder();
        break;
         
    case "orders":
        $productController = new ProductController();
        $productController->showOrders();
        break;   
        
    case "deleteOrder":
        $userController = new UserController();
        $userController->deleteOrder();
        break;
         
        
    case "adminDeleteOrder":
        $adminController = new AdminController();
        $adminController->adminDeleteOrder();
        break; 
        
    case "formModifyOrder":
        $controller = new ProductController();
        $controller->formModifyOrder();
        break;
        
    case "adminModifyOrder":
        $controller = new AdminController();
        $controller->adminModifyOrder();
        break;
    
     case "adminDeleteUser":
        $adminController = new AdminController();
        $adminController->adminDeleteUser();
        break;   
        
    case "showOneProduct":
        $productController = new ProductController();
        $productController->showOneProduct();
        break;        
        
    case "search":
        $controller = new ProductController();
        $controller->querySearch();
        break;   
        
}


