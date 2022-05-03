<?php
 
 
class Authentificator{
     
    
    public function __construct(){
        
        $user = new User;
    }
     
    public function checkUser(){
        
            if(!isset($_SESSION['user'])){
                
                $_SESSION['error'] = "vous devez être connecté";  
                
                header('location: ./index.php?url=login');
                exit();
            }
        
        $userAuth = unserialize($_SESSION['user']);
        return $userAuth;
    }
    
    
    public function csrfTokenChecker()
    {
        
     if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
           
            $_SESSION['error'] = "Vous nêtes pas autorisé";
            header('location: ./index.php?url=login');
            exit();
        }    
        
        
    }
 }

?>