<?php 
require_once './view/UserView.php';
require_once './Repository/UserRepository.php';
require_once './Repository/BasketRepository.php';
require_once './model/class/User.php';

class AdminController {
    
    /*private $view; interet???*/
    
    
     public function __construct()
    {
        $this->view = new UserView();
        $this->repository = new UserRepository();
        $this->basket = new BasketRepository();
    }
    
    public function  adminAccount()
    {
        
        if(!isset($_SESSION['user']) or $_SESSION['role'] !== "admin"){
            header('location: ./index.php?url=login');
            exit();
        }
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
         echo $this->view->displayadminAccount();
    }
   
    
}






