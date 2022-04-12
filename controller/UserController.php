<?php 
require_once './view/UserView.php';
require_once './Repository/UserRepository.php';
require_once './Repository/BasketRepository.php';
require_once './model/class/User.php';

class UserController {
    
    /*private $view; interet???*/
    
    
     public function __construct()
    {
        $this->view = new UserView();
        $this->repository = new UserRepository();
        $this->basket = new BasketRepository();
    }
    
    public function login(){
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        echo $this->view->displayLogin();
    }
    
    public function loginSecurity(): void 
    {
        if(!isset($_POST['email'], $_POST['password'])){
            header('location: ./index.php?url=login');
            exit();
        }
        
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $data = $this->repository->fetchLogin($email);
             
        if(!$_POST['CSRFtoken'] === $_SESSION['csrf']){
            
            header('location: ./index.php?url=login');
        }
         
        if(!password_verify($password, $data['password'])){
            header('location:./index.php?url=login');
            exit();
        }
        
        if($data){
           
            $user = new User();
            $user->setid($data['id']);
            $user->setlastName($data['last_name']);
            $user->setFirstName($data['first_name']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setRole($data['role']);
            $user->setAdresse($data['adress']);
            $user->setWallet($data['wallet']);
            
            $_SESSION['user'] = serialize($user);
            
            $_SESSION['userid'] = serialize($user->getId()); /*(droit de le faire en non serialize)*/
           
            $_SESSION['role'] = $user->getRole();
            
            
                if($user->getRole() === "admin"){
                    header('location: ./index.php?url=adminaccount');
                    exit();
                }else{
                    header('location: ./index.php?url=account');
                    exit();
                }
        }
    }
    
    public function account()
    {
        if(!isset($_SESSION['user'])){
            header('location: ./index.php?url=login');
            exit();
        }
        
        if($_SESSION['role'] === "admin")
        {   
            header('location: ./index.php?url=adminaccount');
            exit();
        }
        
        $userId = unserialize($_SESSION['userid']);
        $data = $this->repository->findById($userId);
        $user = new User;
        $user->setid($data['id']);
        $user->setlastName($data['last_name']);
        $user->setFirstName($data['first_name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setRole($data['role']);
        $user->setAdresse($data['adress']);
        $user->setWallet($data['wallet']);
        
        
        echo $this->view->displayAccount($user);
    }
    
    public function register()
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        echo $this->view->displayRegister();
    }

   public function registerSecurity() : void
    {
    
        if(!isset($_POST['lastName'],$_POST['firstName'],$_POST['email'], $_POST['password'],$_POST['adress'])){
                header('location: ./index.php?url=register');
                exit();
            }
        
        if(!$_POST['CSRFtoken'] === $_SESSION['csrf']){
            echo 'Mot de passe incorrect';
        }
        
        if(isset($_POST['lastName'],$_POST['firstName'],$_POST['email'], $_POST['password'],$_POST['adress'])){
        
            $newlastName = htmlspecialchars($_POST['lastName']);
            $newfirstName = htmlspecialchars($_POST['firstName']);
            $newEmail = htmlspecialchars($_POST['email']);
            $newAdress = htmlspecialchars($_POST['adress']);
            $Pass = htmlspecialchars($_POST['password']);
            $newPass = password_hash($Pass, PASSWORD_DEFAULT);
            $date;
            $wallet = 0;
           
           /*correction a faire ici*/
            $this->repository->createUser($newlastName,$newfirstName,$newEmail,$newPass,$newAdress,$wallet);
            
            header('location: ./index.php?url=registeraccepted&message=votre compte a été crée');
            exit();
        }
        header('location: ./index.php?url=registeraccepted&message="Compte non crée"');
        exit();
        
    }
    
    public function registerAccepted() 
    {
        if(isset($_GET['message'])){
        
            $_SESSION['message'] = $_GET['message'];
        }else{
            $_SESSION['message'] = '';
        }
        
        
        echo $this->view->displayRegisterAccepted();
    }
    
    
    public function formModifyUser():void
    {
        $userId = $_GET['id'];
        $data = $this->repository->findById($userId);
        $user = new User();
        $user->setid($data['id']);
        $user->setlastName($data['last_name']);
        $user->setFirstName($data['first_name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setRole($data['role']);
        $user->setAdresse($data['adress']);
        $user->setWallet($data['wallet']);
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        echo $this->view->displayFormModifyUser($user);
    }
    
     public function modifyUser():void
    {
         if(!$_POST['CSRFtoken'] === $_SESSION['csrf']){
            echo 'Mauvais chemin';
        }
        
        if(!isset($_SESSION['user'])){
            header('location: ./index.php?url=login');
            exit();
        }
        
        $userId = $_GET['id'];
        
        $newlastName = htmlspecialchars($_POST['lastName']);
        $newfirstName = htmlspecialchars($_POST['firstName']);
        $newEmail = htmlspecialchars($_POST['email']);
        $newAdress = htmlspecialchars($_POST['adress']);
        $Pass = htmlspecialchars($_POST['password']);
        $newPass = password_hash($Pass, PASSWORD_DEFAULT);
        $this->repository->modifyUser($userId,$newlastName,$newfirstName,$newEmail,$newAdress,$newPass);    
        
        header('location: ./index.php?url=registeraccepted&message=votre compte a été modifié');
        exit();
    }
    
     
     
    public function logout() : void
    {
        session_destroy();
        header('location: ./index.php?url=home');
        exit();
    }
    
     public function deleteUser() : void
    {
       
        if(isset($_SESSION['userid'])){
        
            $id = unserialize($_SESSION['userid']);
            $this->repository->deleteUser($id);
            
            session_destroy();
            header('location: ./index.php?url=registeraccepted&message=votre compte a été effacé');
            exit();
        }
        header('location: ./index.php?url=login&error=veuillez vous connecter');
        exit();
    }
    
    public function addArticleToBasket()
    {
        if(!isset($_GET['id'],$_SESSION['user'])){
            
            header('location: ./index.php?url=login&error=veuillez vous connecter');
            exit();
        }
            
            $productid = $_GET['id'];
            $userid = unserialize($_SESSION['userid']);
            $this->basket->addArticleToBasket($userid,$productid);
        
            header('location: ./index.php?url=registeraccepted&message=article ajouté au panier');
            exit();
       
    }
    
    
    public function deleteArticleFromBasket()
    {
        if(!isset($_GET['id'])){
            
            header('location: ./index.php?url=login&error=veuillez vous connecter');
            exit();
            
        }
        
        $productid = $_GET['id'];
       
        $this->basket->deleteArticleFromBasket($productid);
        
        header('location: ./index.php?url=registeraccepted&message=article supprimé du panier');
        exit();
        
    
    }
}






