<?php
// Router
session_start();

require_once './controller/HomeController.php';
require_once './controller/UserController.php';
require_once './controller/ProductController.php';
require_once './controller/AdminController.php';

/*definit la valeur de l'url si aucune valeur  récupérée 
alors url prend la valeure de home*/
$url = isset($_GET['url']) ? $_GET['url'] : "home"; 


switch($url){
    // Route index.php?url=home
    case "home": 
        $homeController = new HomeController();
        $homeController->home();
        break;
        
    // Route index.php?url=login
    case "login":
        $userController = new UserController();
        $userController->login();
        break;
        
    // Route index.php?url=loginSecurity
    case "loginSecurity":
        $userController = new UserController();
        $userController->loginSecurity();
        break;
    
    // Route index.php?url=registerSecurity
    case "registerSecurity":
        $userController = new UserController();
        $userController->registerSecurity();
        break;
    
    // Route index.php?url=register
    case "register":
        $userController = new UserController();
        $userController->register();
        break;
    
    // Route index.php?url=registerAccepted
    case "registerAccepted":
        $userController = new UserController();
        $userController->registerAccepted() ;
        break;
        
    // Route index.php?url=confirmationOrNot
    case "confirmationOrNot":
        $homeController = new homeController();
        $homeController->confirmationOrNot() ;
        break;
    
     // Route index.php?url=account   
    case "account":
        $userController = new UserController();
        $userController->account();
        break;
        
    // Route index.php?url=formModifyUser
     case "formModifyUser":
        $userController = new UserController();
        $userController->formModifyUser();
        break;
        
    // Route index.php?url=modifyUser
    case "modifyUser":
        $userController = new UserController();
        $userController->modifyUser();
        break;
        
    // Route index.php?url=addMoney    
    case "addMoney":
        $userController = new UserController();
        $userController->addMoney();
        break;  
        
    // Route index.php?url=logout   
    case "logout":
        $userController = new UserController();
        $userController->logout();
        break;        
    
    // Route index.php?url=shop   
    case "shop":
        $homeController = new homeController();
        $homeController->shop();
        break;
        
    // Route index.php?url=instruments       
    case "instruments":
        $productController = new ProductController();
        $productController->instruments();
        break;
        
    // Route index.php?url=basket       
    case "basket":
        $userController = new UserController();
        $userController->basket();
        break;
        
    // Route index.php?url=addBasket       
     case "addBasket":
        $userController = new UserController();
        $userController->addArticle();
        break;  

    // Route index.php?url=deleteBasket    
    case "deleteBasket":
        $userController = new UserController();
        $userController->deleteBasket();
        break; 
    
    // Route index.php?url=adminAccount   
    case "adminAccount":
        $adminController = new AdminController();
        $adminController->adminAccount();
        break; 
        
    // Route index.php?url=createProduct       
    case "createProduct":
        $productController = new ProductController();
        $productController->createProduct();
        break;    
    
    // Route index.php?url=formModifyProduct   
    case "formModifyProduct":
        $productController = new ProductController();
        $productController->formModifyProduct();
        break;     
    
    // Route index.php?url=modifyProduct 
    case "modifyProduct":
        $productController = new ProductController();
        $productController->modifyProduct();
        break;    
        
    // Route index.php?url=deleteProduct     
    case "deleteProduct":
        $productController = new ProductController();
        $productController->deleteProduct();
        break;  
        
    // Route index.php?url=createCategory      
    case "createCategory":
        $productController = new ProductController();
        $productController->createCategory();
        break;
        
    // Route index.php?url=formModifyCategory     
    case "formModifyCategory":
        $productController = new ProductController();
        $productController->formModifyCategory();
        break;  
        
    // Route index.php?url=modifyCategory      
    case "modifyCategory":
        $productController = new ProductController();
        $productController->modifyCategory();
        break;  
        
    // Route index.php?url=deleteCategory         
    case "deleteCategory":
        $productController = new ProductController();
        $productController->deleteCategory();
        break;      

    // Route index.php?url=addArticleToBasket 
    case "addArticleToBasket":
        $userController = new UserController();
        $userController->addArticleToBasket();
        break;
        
    // Route index.php?url=deleteUser     
    case "deleteUser":
        $userController = new UserController();
        $userController->deleteUser();
        break;
        
    // Route index.php?url=deleteArticleFromBasket    
    case "deleteArticleFromBasket":
        $userController = new UserController();
        $userController->deleteArticleFromBasket();
        break;
        
    // Route index.php?url=createOrder    
    case "createOrder":
        $userController = new UserController();
        $userController->createOrder();
        break;
         
    // Route index.php?url=orders         
    case "orders":
        $userController = new UserController();
        $userController->showOrders();
        break;   
        
    // Route index.php?url=deleteOrder     
    case "deleteOrder":
        $userController = new UserController();
        $userController->deleteOrder();
        break;
         
    // Route index.php?url=adminDeleteOrder      
    case "adminDeleteOrder":
        $adminController = new AdminController();
        $adminController->adminDeleteOrder();
        break; 
        
    // Route index.php?url=formModifyOrder    
    case "formModifyOrder":
        $controller = new ProductController();
        $controller->formModifyOrder();
        break;
        
    // Route index.php?url=adminModifyOrder     
    case "adminModifyOrder":
        $controller = new AdminController();
        $controller->adminModifyOrder();
        break;
        
    // Route index.php?url=adminDeleteUser
     case "adminDeleteUser":
        $adminController = new AdminController();
        $adminController->adminDeleteUser();
        break;   
        
    // Route index.php?url=showOneProduct    
    case "showOneProduct":
        $productController = new ProductController();
        $productController->showOneProduct();
        break;        
        
    // Route index.php?url=search     
    case "search":
        $productController = new ProductController();
        $productController->querySearch();
        break;   
        
}

?>