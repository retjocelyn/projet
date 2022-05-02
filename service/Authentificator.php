<?php
 
 
class Authentificator{
     
    
    public function __construct(){
        
        $user = new User;
    }
     
    public function checkUser(){
        
            if(!isset($_SESSION['user'])){
                
            header('location: ./index.php?url=login&error="veuillez vous connecter"');
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