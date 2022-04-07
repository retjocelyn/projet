<?php 

require_once './Repository/ProductRepository.php';
require_once './Repository/CategoryRepository.php';
require_once './Repository/BasketRepository.php';
require_once './Repository/OrderRepository.php';
require_once './model/class/Product.php';
require_once './model/class/Category.php';
require_once './view/ProductView.php';

class ProductController {
    
    private $view;
    
    public function __construct(){
        $this->view = new ProductView();
        $this->repository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->basketRepository = new BasketRepository();
        $this->orderRepository = new OrderRepository();
    }
    
    
    public function instruments(): void
    {
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
        
         if(isset($_POST['category'],$_POST['name'],$_POST['description'], $_POST['price'],$_POST['quantity'],$_FILES)){
           
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
            
            
            header('location: ./index.php?url=registeraccepted&message=article créer');
            exit();
        }
       
            header('location: ./index.php?url=registeraccepted&message=article non crée');
            exit();
    }
    
    
    public function formModifyProduct()
    {
        $datas = $this->categoryRepository->findAll();
        $categories = [];
        
        foreach($datas as $data){
            $category = new Category();
            $category->setName($data['name']);
            $category->setId($data['id']);
            
            $categories[] = $category;
        }
        
        $produit = $_GET['id'];
        $data = $this->repository->findById($produit);
        $product = new Product();
        $product->setId($data['id']);
        $product->setName($data['name']);
        $product->setQuantity($data['quantity']);
        $product->setPrice($data['price']);
        $product->setImage($data['url_picture']);
        $product->setDescription($data['description']);
        $product->setCategory($data['category_id']);
        
        
        echo $this->view->displayFormModifyProduct($product,$categories);
    }
    
     public function modifyProduct()
     {
          
         if(isset($_POST['id'],$_POST['category'],$_POST['name'],$_POST['description'], $_POST['price'],$_POST['quantity'],$_FILES)){
            
            $tmpName = $_FILES['file']['tmp_name'];
            $name = basename($_FILES['file']['name']);
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
          
            move_uploaded_file($tmpName,'./public/assets/img/'.$name);
            $id = $_POST['id'];
            $newProductCategory = $_POST['category'];
            $newProductName= $_POST['name'];
            $newProductDescription = $_POST['description'];
            $newProductPrice = (int)$_POST['price'];
            $newProductQuantity = (int)$_POST['quantity'];
            $newProductImage = "./public/assets/img/$name";
            
            $this->repository->modifyProduct($id,$newProductCategory,$newProductName,$newProductDescription,$newProductPrice,$newProductQuantity,$newProductImage);
            
            
            header('location: ./index.php?url=registeraccepted&message=article modifié');
            exit();
            
        }
        header('location: ./index.php?url=registeraccepted&message=article non modifié');
    }
    
     public function deleteProduct()
     {
           if(isset($_GET['id']))
           {
                $id = $_GET['id'];
                $this->repository->deleteProduct($id); 
                header('location: ./index.php?url=registeraccepted&message=article effacé');
                exit();
            }
            
            header('location: ./index.php?url=registeraccepted&message=article non effacé');
            exit();
    }
    
    public function createCategory()
    {
        if($_POST['CSRFtoken'] !== $_SESSION['csrf']){
            
            header('location: ./index.php?url=registeraccepted&message=categorie non créée');
            exit();
        }
        
        if(isset($_POST['name'],$_FILES)){
            
            $tmpName = $_FILES['file']['tmp_name'];
            $name = basename($_FILES['file']['name']);
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
          
            move_uploaded_file($tmpName,'./public/assets/img/'.$name);
            $newCategoryName = $_POST['name'];
            $newCategoryImage = "./public/assets/img/$name";
            $this->categoryRepository->createCategory($newCategoryName,$newCategoryImage);
            
            header('location: ./index.php?url=registeraccepted&message=categorie créée');
            exit();
        }
        
            header('location: ./index.php?url=registeraccepted&message=categorie non créée');
            exit();
    }
     public function formModifyCategory()
    {
        $category = $_GET['id'];
        $data = $this->categoryRepository->findById($category);
        $category = new Category();
        $category->setId($data['id']);
        $category->setName($data['name']);
        $category->setUrlImage($data['url_picture']);
        
        echo $this->view->displayFormModifyCategory($category);
    }
    
    public function modifyCategory()
    {
        if(isset($_POST['id'],$_POST['name'],$_FILES))
        {
            
            $tmpName = $_FILES['file']['tmp_name'];
            $name = basename($_FILES['file']['name']);
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
          
            move_uploaded_file($tmpName,'./public/assets/img/'.$name);
            $id = $_POST['id'];
            $newCategoryName = $_POST['name'];
            $newProductImage = "./public/assets/img/$name";
            
            $this->categoryRepository->modifyCategory($id,$newCategoryName,$newProductImage);
            
            header('location: ./index.php?url=registeraccepted&message=categorie modifiée');
            exit();
        }
        header('location: ./index.php?url=registeraccepted&message=categorie non modifiée');
        exit();
    }
    
    public function deleteCategory()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $this->categoryRepository->deleteCategory($id);
        
            header('location: ./index.php?url=registeraccepted&message=catégorie supprimée');
            exit();
        }
        header('location: ./index.php?url=registeraccepted&message=catégorie non supprimée');
        exit();
    }
    
    public function basket() : void
    {
       if(!isset($_SESSION['user'])){
           
        header('location: ./index.php?url=login&message=Pas connecté a votre compte');
        exit();
        
       }
       
        $userid =unserialize($_SESSION['userid']);
        $datas = $this->basketRepository->findById($userid);
        $prices = [];
        $products = [];
            
        foreach($datas as $data){
            $product = new Product();
            $product->setId($data['product_id']);
            $product->setName($data['name']);
            $product->setQuantity($data['quantity']);
            $product->setPrice($data['price']);
            $product->setImage($data['url_picture']);
            $product->setDescription($data['description']);
            $product->setCategory($data['category_id']);
            
            $products[] = $product;
            $prices[] = $product->getPrice();
        }
        
        $totalprice = array_sum($prices);
        
        echo $this->view->displayBasket($products,$totalprice);
   }
   
    public function createOrder(): void 
    {
        if(!isset($_SESSION['user'])){
           
        header('location: ./index.php?url=login&message=Pas connecté a votre compte');
        exit();
        
       }
       
       $userid = unserialize($_SESSION['userid']);
       
       $datas = $this->basketRepository->findById($userid);
       $productsid = [];
       
       foreach($datas as $data){
           $productsid[] = $data['product_id'];
       }
      
       $this->orderRepository->createOrder($userid,$productsid);
       $this->basketRepository->deleteBasket($userid);
       
       header('location: ./index.php?url=registeraccepted&message=votre commande à été créée');
       exit();
    }
    
    
     public function showOrders() : void
    {
       if(!isset($_SESSION['user'])){
           
        header('location: ./index.php?url=login&message=Pas connecté a votre compte');
        exit();
        
       }
       
        $userid =unserialize($_SESSION['userid']);
        $datas = $this->orderRepository->findById($userid);
        
        $products = [];
            
        foreach($datas as $data){
            $product = new Product();
            $product->setId($data['product_id']);
            $product->setName($data['name']);
            $product->setQuantity($data['quantity']);
            $product->setPrice($data['price']);
            $product->setImage($data['url_picture']);
            $product->setDescription($data['description']);
            $product->setCategory($data['category_id']);
            
            $products[] = $product;
           
        }
        
        echo $this->view->displayOrder($products);
   }
   
   
    public function deleteOrder(): void
    {
        
     if(!isset($_SESSION['user'])){
           
        header('location: ./index.php?url=login&message=Pas connecté a votre compte');
        exit();
        
       }
        $userid =unserialize($_SESSION['userid']);
        $this->orderRepository->deleteOrder($userid);
        
        header('location: ./index.php?url=registeraccepted&message=commande supprimée');
        exit();
   }
    
}