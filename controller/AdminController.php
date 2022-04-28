<?php 
require_once './view/UserView.php';
require_once './view/ProductView.php';
require_once './repository/UserRepository.php';
require_once './model/class/Product.php';
require_once './model/class/Product.php';
require_once './repository/ProductRepository.php';
require_once './repository/CategoryRepository.php';
require_once './repository/OrderRepository.php';
require_once './model/class/User.php';
require_once './model/class/Order.php';

class AdminController {
    
    /*private $view; interet???*/
    
    
     public function __construct()
    {
        $this->view = new UserView();
        $this->productView = new ProductView();
        $this->repository = new UserRepository();
        $this->basket = new BasketRepository();
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->orderRepository = new OrderRepository();
    }
    
    public function  adminAccount()
    {
        $user = unserialize($_SESSION['user']);
        
        if(!isset($_SESSION['user']) or $user->getRole() !== "admin"){
            header('location: ./index.php?url=login');
            exit();
        }
        
        /*$_SESSION['csrf'] = bin2hex(random_bytes(32));*/
        
        $datas = $this->productRepository->findAll();
        
        $products = [];
        
        foreach($datas as $data){
            $product = new Product();
            $product->setId($data['id']);
            $product->setName($data['name']);
            $product->setQuantity($data['quantity']);
            $product->setPrice($data['price']);
            $product->setImage($data['url_picture']);
            $product->setDescription($data['description']);
            $product->setCategory($data['category_id']);
            
            
            $products[] = $product;
           
        }
        
        $datas = $this->categoryRepository-> findAll();
        
        $categories = [];
        
        foreach($datas as $data){
            $category = new Category();
            $category->setId($data['id']);
            $category->setName($data['name']);
            $category->setUrlImage($data['url_picture']);
            
            $categories[] = $category;
           
        }
        $datas = $this->orderRepository->findAllOrders();
        $commandes = [];
    
        foreach($datas as $data){
            $order = new Order();
            $order->setId($data['id']);
            $order->setDate($data['created_at']);
            $order->setCommandUserFamilyName($data['first_name']);
            $order->settCommandUserName($data['last_name']);
            $order->setCommandUserAdress($data['adress']);
            $order->setCommandProductImage($data['url_picture']);
            $order->setCommandProductName($data['name']);
            $order->setCommandProductQuantity($data['quantity']);
            $order->setCommandProductPrice($data['price']);
            
             $commandes[] = $order;
         }
         
        $datas = $this->repository->fetchAll();
        $users = [];
         foreach($datas as $data){
            $user = new User();
            $user->setid($data['id']);
            $user->setlastName($data['last_name']);
            $user->setFirstName($data['first_name']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setRole($data['role']);
            $user->setAdresse($data['adress']);
            $user->setWallet($data['wallet']);
            
             $users[] = $user;
         }
        
        echo $this->productView->displayadminAccount($products,$categories,$commandes,$users);
    }
    
    public function adminDeleteOrder(){
        
     if(!isset($_SESSION['user']) or $_SESSION['role'] !== "admin"){
         
            header('location: ./index.php?url=login');
            exit();
            
        }
        
        $orderId = $_GET['id'];
        $this->orderRepository->adminDeleteOrder($orderId);
        
        header('location: ./index.php?url=confirmationornot&message=commande supprimée');
        exit();
        
    }    
    
     public function adminDeleteUser():void
    {
        
         if(!isset($_SESSION['user']) or $_SESSION['role'] !== "admin"){
             
                header('location: ./index.php?url=login');
                exit();
                
        }
        
        $id = $_GET['id'];
        $this->repository->deleteUser($id);
        
        header('location: ./index.php?url=confirmationornot&message=client supprimé');
        exit();
    } 
    
}






