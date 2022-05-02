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
        $userId = unserialize($_SESSION['user']);
        return $userid->getId();
    }
    
    
    public function CsrfTokenChecker(){
        
        if(!$_POST['CSRFtoken'] === $_SESSION['csrf']){
            echo "Faux mot de passe";
        }
        
    }
 }

?>