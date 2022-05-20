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
        $this->authentificator = new Authentificator();
       
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
                header('location: ./index.php?url=adminAccount');
                exit();
            }else{
                header('location: ./index.php?url=account');
                exit();
            }
            
        }
    }
    
    public function account()
    {
         
        $userAuth = $this->authentificator->checkUser();
       
        if($userAuth->getRole() === "admin"){
            header('location: ./index.php?url=adminAccount');
            exit();
        }
      
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
       
       
        $data = $this->repository->findById($userAuth->getId());
         
        $user = new User();
        $user->setId($data['id']);
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
        
        $this->authentificator->csrfTokenChecker();
        
        $email = htmlspecialchars($_POST['email']);
        
        $data = $this->repository->fetchLogin($email);
            
        if($data !== false){    
            $_SESSION['error'] = "Email existe déja";
            header('location:./index.php?url=login');
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
            $user->setWallet(0,00);
            $user->setRole('client');
          
          
            if($query = $this->repository->createUser($user)){
              
                header('location: ./index.php?url=registerAccepted&message="votre compte a été crée"');
                exit();
            }
         
            header('location: ./index.php?url=confirmationOrNot&message="Compte non crée"');
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
        $this->authentificator->csrfTokenChecker();
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $userId = $_POST['id'];
        
        $data = $this->repository->findById($userId);
        
        $user = new User();
        $user->setId($data['id']);
        $user->setlastName($data['last_name']);
        $user->setFirstName($data['first_name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setRole($data['role']);
        $user->setAdresse($data['adress']);
        $user->setWallet($data['wallet']);
       
        echo $this->view->displayFormModifyUser($user);
    }
    
    
    public function modifyUser():void
    {
        
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkUser();
        
        $user = new User();
        $user->setId($_POST['id']);
        $user->setlastName(htmlspecialchars($_POST['lastName']));
        $user->setFirstName(htmlspecialchars($_POST['firstName']));
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setAdresse(htmlspecialchars($_POST['adress']));
        $user->setRole(htmlspecialchars($_POST['role']));
        $user->setWallet(htmlspecialchars((float)$_POST['userwallet']));
        $Pass = htmlspecialchars($_POST['password']);
        $user->setPassword(password_hash($Pass, PASSWORD_DEFAULT));
        
        if($this->repository->modifyUser($user)){
       
            $_SESSION['user'] = serialize($user);
            
            header('location: ./index.php?url=confirmationOrNot&message="Compte modifié"');
            exit();
        }   
        
        header('location: ./index.php?url=confirmationOrNot&message="Compte non modifié"');
        exit();
        
    }
    
    
    public function addMoney() : void
    {
        
        $userAuth = $this->authentificator->checkUser();
        $this->authentificator->csrfTokenChecker();
        
        if(!isset($_POST['amount'])){
            header('location: ./index.php?url=confirmationOrNot&message="Argent non ajouté"');
            exit();
        }    
           
            $amount = (float)htmlspecialchars($_POST['amount']);
            
            $datas = $this->repository->findById($userAuth->getId());
            
            $userWallet = (float)$datas['wallet'];
            
            $newAmount = $userWallet + $amount;
           
            if($this->repository->addMoney($userAuth->getId(),$newAmount)){
                
                
                $userAuth->setWallet($newAmount);
                $_SESSION['user'] = serialize($userAuth);
               
                header('location: ./index.php?url=confirmationOrNot&message="Argent ajouté"');
                exit();
            
            }
        
            header('location: ./index.php?url=confirmationOrNot&message="Argent non ajouté"');
            exit();
    }
    
     
     
    public function logout() : void
    {
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
        
        session_destroy();
        header('location: ./index.php?url=home');
        exit();
    }
    
    public function deleteUser() : void
    {
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
       
        if($this->repository->deleteUser($userAuth->getId())){
        
            session_destroy();
            
            header('location: ./index.php?url=confirmationOrNot&message=votre compte a été effacé');
            exit();
        }
        
        header('location: ./index.php?url=confirmationOrNot&message=compte non effacé');
        exit();
    }
    
    public function addArticleToBasket()
    {
       
        
        $userAuth = $this->authentificator->checkUser();
        $this->authentificator->csrfTokenChecker();
            
        $productId = $_POST['id'];
            
        if($this->basket->addArticleToBasket($userAuth->getId(),$productId)){
        
            header('location: ./index.php?url=confirmationOrNot&message=article ajouté au panier');
            exit();
        }    
       
        header('location: ./index.php?url=confirmationOrNot&message=article non ajouté au panier');
        exit();
    }
    
    
    public function deleteArticleFromBasket()
    {
        
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
        
        if(!isset($_POST['id'])){
            
            header('location: ./index.php?url=shop');
            exit();
            
        }
        
        $ArticleBasketId = $_POST['id'];
       
       
        if($this->basket->deleteArticleFromBasket($ArticleBasketId)){
        
            header('location: ./index.php?url=confirmationOrNot&message=article supprimé du panier');
            exit();
        
        }
        
        header('location: ./index.php?url=confirmationOrNot&message=article non supprimé du panier');
        exit();
    }
}






