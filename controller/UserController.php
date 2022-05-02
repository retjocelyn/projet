<?php 
require_once './view/UserView.php';
require_once './repository/UserRepository.php';
require_once './repository/BasketRepository.php';
require_once './model/class/User.php';
require_once './service/Authentificator.php';

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
            
            $_SESSION['error'] = "vous n'avez pas remplis le formulaire";
            header('location:./index.php?url=login');
            exit();
        }
          
       if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
           
            $_SESSION['error'] = "Vous nêtes pas autorisé";
            header('location: ./index.php?url=login');
            exit();
        }
           
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
        $data = $this->repository->fetchLogin($email); 
       
        if($data === false){
            $_SESSION ['error'] = "Identifiant incconu";
            header('location:./index.php?url=login');
            exit();
          }
        
        if(!password_verify($password, $data['password'])){
            $_SESSION ['error'] = "Mauvais mot de passe";
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
         $authentificator = new Authentificator();
         $user = $authentificator->checkUser();
        
        if($user->getRole() === "admin")
        {   
            header('location: ./index.php?url=adminaccount');
            exit();
        }
      
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
       
        $data = $this->repository->findById($user->getId());
        $user = new User();
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
    
        if(empty($_POST)){
            
            $_SESSION['error'] = "document non remplis";
            header('location: ./index.php?url=register');
            exit();
        }
        
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
           
            $_SESSION['error'] = "Vous nêtes pas autorisé";
            header('location: ./index.php?url=login');
            exit();
        }
        
        $email = htmlspecialchars($_POST['email']);
        
        $data = $this->repository->fetchLogin($email);
            
        if($data === true){    
           
            $_SESSION['error'] = "Email existe déja";
            header('location: ./index.php?url=login');
            exit();
        }
        
        if(isset($_POST['lastName'],$_POST['firstName'],$_POST['email'], $_POST['password'],$_POST['adress'])){
            $user = new User();
            $user->setlastName(htmlspecialchars($_POST['lastName']));
            $user->setFirstName(htmlspecialchars($_POST['firstName']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setAdresse(htmlspecialchars($_POST['adress']));
            $Pass = htmlspecialchars($_POST['password']);
            $user->setPassword(password_hash($Pass, PASSWORD_DEFAULT));
            $user->setWallet(0);
            $user->setRole('client');
          
          
            if($query = $this->repository->createUser($user)){
              
                $_SESSION['user'] = serialize($user);
                header('location: ./index.php?url=registeraccepted&message="votre compte a été crée"');
                exit();
            }
         
        header('location: ./index.php?url=confirmationornot&message="Compte non crée"');
        exit();
         }    
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
    
     public function confirmationOrNot() 
    {
        if(isset($_GET['message'])){
        
            $_SESSION['message'] = $_GET['message'];
        }else{
            $_SESSION['message'] = '';
        }
        
        
        echo $this->view->displayConfirmationOrNot();
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
            echo 'error 401';
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
        
        header('location: ./index.php?url=confirmationornot&message=votre compte a été modifié');
        exit();
    }
    
    public function addMoney() : void
    {
        
         if(!isset($_SESSION['user'])){
            header('location: ./index.php?url=login');
            exit();
        }
        
        if(!$_POST['CSRFtoken'] === $_SESSION['csrf']){
            
            header('location: ./index.php?url=login');
            exit();;
        }
        
        if(isset($_POST['amount'])){
           
            $amount = htmlspecialchars($_POST['amount']);
            $userId = $_GET['id'] ;
            $this->repository->addMoney($userId,$amount);
            header('location: ./index.php?url=confirmationornot&message="Argent ajouté"');
            exit();
            
        }
        
        if(isset($_SESSION['error'])){
            header('location: ./index.php?url=confirmationornot&message="Une erreur est survenue"');
            exit();
        }
        
        header('location: ./index.php?url=confirmationornot&message="Argent non ajouté"');
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
            header('location: ./index.php?url=confirmationornot&message=votre compte a été effacé');
            exit();
        }
        
        header('location: ./index.php?url=login&error=veuillez vous connecter');
        exit();
    }
    
    public function addArticleToBasket()
    {
       
        if(!isset($_SESSION['user'])){
            
            header('location: ./index.php?url=login&error=veuillez vous connecter');
            exit();
        }
            
            $productid = $_GET['id'];
            $userid = unserialize($_SESSION['userid']);
            $this->basket->addArticleToBasket($userid,$productid);
        
            header('location: ./index.php?url=confirmationornot&message=article ajouté au panier');
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
        
        header('location: ./index.php?url=confirmationornot&message=article supprimé du panier');
        exit();
    
    }
}






