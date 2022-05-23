<?php
 
 
class Authentificator{
     
    
    public function __construct(){
        
        $user = new User; /*pas besoin je crois)*/
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
           
            $_SESSION['error'] = "403 Vous nêtes pas autorisé";
            
            header('location: ./index.php?url=login');
            exit();
        }    
        
    }
    
     public function checkAdmin()
     {
        
        if(!isset($_SESSION['user'])){
            
            $_SESSION['error'] = "vous devez être connecté";  
            
            header('location: ./index.php?url=login');
            exit();
        }
        
        $adminChecked = unserialize($_SESSION['user']);
       
        if($adminChecked->getRole() !== "admin"){
            
            $_SESSION['error'] = "403 vous n'êtes pas autorisé";  
            
            header('location: ./index.php?url=login');
            exit();
            
        }
        
        return $adminChecked;
    }
 }


?>