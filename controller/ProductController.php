<?php 

require_once './Repository/ProductRepository.php';
require_once './model/class/Product.php';
require './view/ProductView.php';

class ProductController {
    
    private $view;
    
    public function __construct(){
        $this->view = new ProductView();
        $this->repository = new ProductRepository;
    }
    
    
    public function instruments(){
        $category = $_GET['id'];
        $datas = $this->repository->findByCategory($category);
        
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
      
       echo $this->view->dislplayInstruments($products);
    }
    
     public function addArticle(){
        echo("oui on ajoute article");
        
    }
    
    public function createProduct(){
        
         if(isset($_POST['category'],$_POST['name'],$_POST['description'], $_POST['price'],$_POST['quantity'],$_POST['image']))
        {
            $newProductCategory = $_POST['category'];
            $newProductName= $_POST['name'];
            $newProductDescription = $_POST['description'];
            $newProductPrice = (int)$_POST['price'];
            $newProductQuantity = (int)$_POST['quantity'];
            $newProductImage = $_POST['image'];
            
            $this->repository->createProduct($newProductCategory,$newProductName,$newProductDescription,$newProductPrice,$newProductQuantity,$newProductImage);
            
            
            header('location: ./index.php?url=registeraccepted&message="article créer"');
            exit();
        }
    }
    
     
}