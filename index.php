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
        $userController = new UserController();
        $userController->basket();
        break;
        
    case "addarticle":
        $productController = new ProductController();
        $productController->addArticle();
        break;
        
    case "adminaccount":
        $adminController = new AdminController();
        $adminController->adminAccount();
        break; 
          
}


