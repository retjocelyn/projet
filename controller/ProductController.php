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
        
         if(isset($_POST['category'],$_POST['name'],$_POST['description'], $_POST['price'],$_POST['quantity'],$_FILES))
        {
            
            $tmpName = $_FILES['file']['tmp_name'];
            $name = basename($_FILES['file']['name']);
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
            move_uploaded_file($tmpName,'./public/assets/img/'.$name);
            
            $newProductCategory = $_POST['category'];
            $newProductName= $_POST['name'];
            $newProductDescription = $_POST['description'];
            $newProductPrice = (int)$_POST['price'];
            $newProductQuantity = (int)$_POST['quantity'];
            $newProductImage = "./public/assets/img/$name";
            
            $this->repository->createProduct($newProductCategory,$newProductName,$newProductDescription,$newProductPrice,$newProductQuantity,$newProductImage);
            
            
            header('location: ./index.php?url=registeraccepted&message="article créer"');
            exit();
        }
        var_dump("pas de produit creer");
        die();
    }
    
    
      public function formModifyProduct()
    {
        
        $produit =  $_GET['id'];
        $data = $this->repository->findByID($produit);
        $category = 
        $product = new Product();
        $product->setId($data['id']);
        $product->setName($data['name']);
        $product->setQuantity($data['quantity']);
        $product->setPrice($data['price']);
        $product->setImage($data['url_picture']);
        $product->setDescription($data['description']);
        $product->setCategory($data['category_id']);
        
        
        echo $this->view->displayFormModifyProduct($product);
    }
     
}