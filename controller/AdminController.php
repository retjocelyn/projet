<?php 
require_once './view/UserView.php';
require_once './view/ProductView.php';
require_once './Repository/UserRepository.php';
require_once './model/class/Product.php';
require_once './Repository/ProductRepository.php';
require_once './model/class/User.php';

class AdminController {
    
    /*private $view; interet???*/
    
    
     public function __construct()
    {
        $this->view = new UserView();
        $this->productView = new ProductView();
        $this->repository = new UserRepository();
        $this->basket = new BasketRepository();
        $this->productRepository = new ProductRepository();

    }
    
    public function  adminAccount()
    {
        
        if(!isset($_SESSION['user']) or $_SESSION['role'] !== "admin"){
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
       
         echo $this->productView->displayadminAccount($products);
    }
    
    public function formModifyProduct()
    {
         echo $this->view->displayFormModifyProduct();
    }
    
}






