<?php 

require_once './repository/ProductRepository.php';
require_once './repository/CategoryRepository.php';
require_once './model/class/Product.php';
require_once './model/class/Category.php';
require_once './view/ProductView.php';
require_once './service/Authentificator.php';

class ProductController {
    
    
    public function __construct(){
        
        $this->view = new ProductView();
        $this->repository = new ProductRepository();
        $this->UserRepository = new UserRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->basketRepository = new BasketRepository();
        $this->authentificator = new Authentificator();
        $product = new Product();
        $this->category = new Category();
        
    }
    
    
    public function instruments(): void
    {
        $categoryId = $_GET['id'];
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $datas = $this->repository->findByCategory($categoryId);
        
        if(isset($datas['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
        
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
    
    
    public function createProduct()
    {
        
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(isset($_POST['category'],$_POST['name'],$_POST['description'], $_POST['price'],$_POST['quantity'],$_FILES)){
           
            $tmpName = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            $temp= explode('.',$file_name);
            $extension = end($temp);
           
            $fileName = md5(time()).'.'.$extension;
            
            /*unité en bytes*/
            $maxSize = 400000;
            
            if($error !== 0 ){
                header('location: ./index.php?url=confirmationOrNot&message= Une erreure est survenue');
                exit();
            }
            
            if($size >= $maxSize){
               
                header('location: ./index.php?url=confirmationOrNot&message=Taille image trop grande');
                exit();
            }
            
            $extensions = ['jpg', 'png', 'jpeg', 'gif'];
            
            if(in_array($extension, $extensions) !== true){
                header('location: ./index.php?url=confirmationOrNot&message=Mauvaise extension');
                exit();
            }
            
            if(!move_uploaded_file($tmpName,'./public/assets/img/'.$fileName)){
               
                header('location: ./index.php?url=confirmationOrNot&message=Article non modifié');
                exit();
            }
            
            $product = new Product();
            $product->setCategory(htmlspecialchars($_POST['category'])); 
            $product->setName(htmlspecialchars($_POST['name']));
            $product->setDescription(htmlspecialchars($_POST['description']));
            $product->setPrice((int)htmlspecialchars($_POST['price']));
            $product->setQuantity((int)htmlspecialchars($_POST['quantity']));
            $product->setImage("./public/assets/img/$fileName");
            
            if($this->repository->createProduct($product)){
                
                header('location: ./index.php?url=confirmationOrNot&message=article créer');
                exit();
            }
            
            header('location: ./index.php?url=confirmationOrNot&message=article non crée');
            exit();
        }
       
    }       
    
    
    public function showOneProduct():void /*revoir si cest bonle view*/
    {
        $productId = $_GET['id'];
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
         
        $data = $this->repository->findById($productId);
        
        if(isset($data['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
        
        $product = new Product();
        $product->setId($data['id']);
        $product->setName($data['name']);
        $product->setQuantity($data['quantity']);
        $product->setPrice($data['price']);
        $product->setImage($data['url_picture']);
        $product->setDescription($data['description']);
        $product->setCategory($data['category_id']);
        
        echo $this->view->displayOneProduct($product);
        
    }
    
    public function querySearch(): void
    {
        $query = $_GET['q'] ?? "";
        $products = $this->repository->fetchQuery($query);
        echo json_encode($products);
    }
    
    public function formModifyProduct()
    {
        
        $this->authentificator->checkAdmin();
        $this->authentificator->csrfTokenChecker();
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $datas = $this->categoryRepository->findAll();
        
        if(isset($datas['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
        
        $categories = [];
        
        foreach($datas as $data){
            $category = new Category();
            $category->setName($data['name']);
            $category->setId($data['id']);
            
            $categories[] = $category;
        }
        
        $produitId = $_POST['id'];
        $data = $this->repository->findById($produitId);
        
        if(isset($data['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
        
        $product = new Product();
        $product->setId($data['id']);
        $product->setName($data['name']);
        $product->setQuantity($data['quantity']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        $product->setCategory($data['category_id']);
        
        
        
        echo $this->view->displayFormModifyProduct($product,$categories);
    }
    
    public function modifyProduct()
    {
        
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(isset($_POST['id'],$_POST['category'],$_POST['name'],$_POST['description'], $_POST['price'],$_POST['quantity'],$_FILES)){
            
            $tmpName = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            $temp= explode('.',$file_name);
            $extension = end($temp);
             /*unité en bytes*/
            $maxSize = 400000;
           
            $fileName = md5(time()).'.'.$extension;
            
            $product = new Product();
            $product->setId(htmlspecialchars($_POST['id']));
            $product->setCategory(htmlspecialchars($_POST['category'])); 
            $product->setName(htmlspecialchars($_POST['name']));
            $product->setDescription(htmlspecialchars($_POST['description']));
            $product->setPrice((int)htmlspecialchars($_POST['price']));
            $product->setQuantity((int)htmlspecialchars($_POST['quantity']));
            $product->setImage("./public/assets/img/$fileName");
           
            if($error !== 0 ){
                header('location: ./index.php?url=confirmationOrNot&message= Une erreure est survenue');
                exit();
            }
            
            if($size >= $maxSize){
               
                header('location: ./index.php?url=confirmationOrNot&message=Taille image trop grande');
                exit();
            }
            
            $extensions = ['jpg', 'png', 'jpeg', 'gif'];
            
            if(in_array($extension, $extensions) !== true){
                header('location: ./index.php?url=confirmationOrNot&message=Mauvaise extension');
                exit();
            }
            
             
            /*recupere l'ancienne image pour l'effacer*/
            
            if(!$data = $this->repository->fetchImage($product->getId())){
                header('location: ./index.php?url=confirmationOrNot&message=Article non modifié');
                exit();
            }
            
            if(isset($data['error'])){
                header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
                exit();
            }
            
            unlink($data['url_picture']);
            
            if(!move_uploaded_file($tmpName,'./public/assets/img/'.$fileName)){
               
                header('location: ./index.php?url=confirmationOrNot&message=Article non modifié');
                exit();
            }
            
            
            if($this->repository->modifyProduct($product)){
            
                header('location: ./index.php?url=confirmationOrNot&message=Article modifié');
                exit();
            
            }
        
            header('location: ./index.php?url=confirmationOrNot&message=article non modifié');
            exit();
        }
    }
    
    
    public function deleteProduct()
    {
        
        $this->authentificator->checkAdmin();
        $this->authentificator->csrfTokenChecker();
       
        if(!isset($_POST['id'])){
           
            header('location: ./index.php?url=confirmationOrNot&message=Article non trouvé');
            exit();
           
        }
        
        $productId = htmlspecialchars($_POST['id']);
        
        $data = $this->repository->fetchImage($productId);
        
        if(isset($data['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
       
        if(!unlink($data['url_picture'])){
            header('location: ./index.php?url=confirmationOrNot&message=Article non effacé');
            exit();
        }
            
        if($this->repository->deleteProduct($productId)){
           
            header('location: ./index.php?url=confirmationOrNot&message=Article effacé');
            exit();
       } 
                
        header('location: ./index.php?url=confirmationOrNot&message=Article non effacé');
        exit();
        
    }        
    
    
    public function createCategory()
    {
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(isset($_POST['name'],$_FILES)){
            
            $tmpName = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            $temp= explode('.',$file_name);
            $extension = end($temp);
           
            $fileName = md5(time()).'.'.$extension;
            
            /*unité en bytes*/
            $maxSize = 400000;
            
            if($error !== 0 ){
                header('location: ./index.php?url=confirmationOrNot&message=Une erreure est survenue');
                exit();
            }
            
            if($size >= $maxSize){
               
                header('location: ./index.php?url=confirmationOrNot&message=Taille image trop grande');
                exit();
            }
            
            $extensions = ['jpg', 'png', 'jpeg', 'gif'];
            
            if(in_array($extension, $extensions) !== true){
                header('location: ./index.php?url=confirmationOrNot&message=Mauvaise extension');
                exit();
            }
            
            if(!move_uploaded_file($tmpName,'./public/assets/img/'.$fileName)){
               
                header('location: ./index.php?url=confirmationOrNot&message=Catégorie non créee');
                exit();
            }
            
            $this->category->setName(htmlspecialchars($_POST['name'])) ;
            $this->category->setUrlImage("./public/assets/img/$fileName");
            
            
            if($this->categoryRepository->createCategory($this->category)){
            
                header('location: ./index.php?url=confirmationOrNot&message=Categorie créée');
                exit();
            }
        
            header('location: ./index.php?url=confirmationOrNot&message=Categorie non créée');
            exit();
        }
    }
    
    public function formModifyCategory()
    {
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $categoryId = htmlspecialchars($_POST['id']);
        $data = $this->categoryRepository->findById($categoryId);
        
        if(isset($data['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
        
        $this->category->setId($data['id']);
        $this->category->setName($data['name']);
        $this->category->setUrlImage($data['url_picture']);
        
        echo $this->view->displayFormModifyCategory($this->category);
    }
    
    
    public function modifyCategory()
    {
        
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(isset($_POST['id'],$_POST['name'],$_FILES))
        {
            $tmpName = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            $temp= explode('.',$file_name);
            $extension = end($temp);
             /*unité en bytes*/
            $maxSize = 400000;
           
            $newFileName = md5(time()).'.'.$extension;
           
            $this->category->setId(htmlspecialchars($_POST['id']));
            $this->category->setName(htmlspecialchars($_POST['name']));
            $this->category->setUrlImage("./public/assets/img/$newFileName");
           
            if($error !== 0 ){
                header('location: ./index.php?url=confirmationOrNot&message=Une erreure est survenue');
                exit();
            }
            
            if($size >= $maxSize){
               
                header('location: ./index.php?url=confirmationOrNot&message=Taille image trop grande');
                exit();
            }
            
            $extensions = ['jpg', 'png', 'jpeg', 'gif'];
            
            if(in_array($extension, $extensions) !== true){
                header('location: ./index.php?url=confirmationOrNot&message=Mauvaise extension');
                exit();
            }
            
             
            /*recupere l'ancienne image pour l'effacer*/
            if(!$data = $this->categoryRepository->fetchImage($this->category->getId())){
                header('location: ./index.php?url=confirmationOrNot&message=Catégorie non modifiée');
                exit();
            }
            
            if(isset($data['error'])){
                header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
                exit();
            }
            
            unlink($data['url_picture']);
        
            if(!move_uploaded_file($tmpName,'./public/assets/img/'.$newFileName)){
               
                header('location: ./index.php?url=confirmationOrNot&message=Catégorie non modifié');
                exit();
            }
            
            
            if($this->categoryRepository->modifyCategory($this->category)){
            
                header('location: ./index.php?url=confirmationOrNot&message=Categorie modifiée');
                exit();
            }
            
        header('location: ./index.php?url=confirmationOrNot&message=Categorie non modifiée');
        exit();
        
        }
    }    
    
    public function deleteCategory():void
    {
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(!isset($_POST['id'])){
            header('location: ./index.php?url=confirmationOrNot&message=Catégorie non supprimée');
            exit();
        }    
        
        $categoryId = $_POST['id'];
        
        $data = $this->categoryRepository->fetchImage($categoryId);
        
        if(isset($data['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
       
        unlink($data['url_picture']);
        
        if($this->categoryRepository->deleteCategory($categoryId)){
        
                header('location: ./index.php?url=confirmationOrNot&message=catégorie supprimée');
                exit();
                
        }
        
        header('location: ./index.php?url=confirmationOrNot&message=Catégorie non supprimée');
        exit();
    }
    
    public function formModifyOrder()
    {
       
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
        
        if(!isset($_POST['id'])){
            header('location: ./index.php?url=confirmationOrNot&message=Commande non modifiée');
            exit();
        }    
        
        $order = $_POST['id'];
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        echo $this->view->displayFormModifyOrder($order);
    }
    
}