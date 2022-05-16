<?php 

require_once './repository/ProductRepository.php';
require_once './repository/CategoryRepository.php';
require_once './repository/BasketRepository.php';
require_once './repository/OrderRepository.php';
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
        $this->orderRepository = new OrderRepository();
        $this->authentificator = new Authentificator();
        $product = new Product();
        $this->category = new Category();
        
    }
    
    
    public function instruments(): void
    {
        $categoryId = $_GET['id'];
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $datas = $this->repository->findByCategory($categoryId);
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
            $temp= explode('.',$file_name);
            $extension = end($temp);
           
            $fileName = md5(time()).'.'.$extension;
            
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
            if(!move_uploaded_file($tmpName,'./public/assets/img/'.$fileName)){
               
                header('location: ./index.php?url=confirmationornot&message=article non modifié');
                exit();
            }
            
            
            move_uploaded_file($tmpName,'./public/assets/img/'.$fileName);
            
            $product = new Product();
            $product->setCategory(htmlspecialchars($_POST['category'])); 
            $product->setName(htmlspecialchars($_POST['name']));
            $product->setDescription(htmlspecialchars($_POST['description']));
            $product->setPrice((int)htmlspecialchars($_POST['price']));
            $product->setQuantity((int)htmlspecialchars($_POST['quantity']));
            $product->setImage("./public/assets/img/$fileName");
            
            if($this->repository->createProduct($product)){
                
                header('location: ./index.php?url=confirmationornot&message=article créer');
                exit();
            }
            
            header('location: ./index.php?url=confirmationornot&message=article non crée');
            exit();
        }
       
    }       
    
    
    public function showOneProduct():view    /*revoir si cest bonle view*/
    {
        $productId = $_GET['id'];
        $data = $this->repository->findById($productId);
        
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
        $categories = [];
        
        foreach($datas as $data){
            $category = new Category();
            $category->setName($data['name']);
            $category->setId($data['id']);
            
            $categories[] = $category;
        }
        
        $produitId = $_POST['id'];
        $data = $this->repository->findById($produitId);
        
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
            $temp= explode('.',$file_name);
            $extension = end($temp);
           
            $newFileName = md5(time()).'.'.$extension;
            
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
            if(!move_uploaded_file($tmpName,'./public/assets/img/'.$newFileName)){
               
                header('location: ./index.php?url=confirmationornot&message=article non modifié');
                exit();
            }
            
            $product = new Product();
            $product->setId(htmlspecialchars($_POST['id']));
            $product->setCategory(htmlspecialchars($_POST['category'])); 
            $product->setName(htmlspecialchars($_POST['name']));
            $product->setDescription(htmlspecialchars($_POST['description']));
            $product->setPrice((int)htmlspecialchars($_POST['price']));
            $product->setQuantity((int)htmlspecialchars($_POST['quantity']));
            $product->setImage("./public/assets/img/$newFileName");
            
            /*recupere l'ancienne image pour l'effacer*/
            if(!$data = $this->repository->fetchImage($product->getId())){
                header('location: ./index.php?url=confirmationornot&message=article non modifié');
                exit();
            }
            
            unlink($data['url_picture']);
            
            if($this->repository->modifyProduct($product)){
            
                header('location: ./index.php?url=confirmationornot&message=article modifié');
                exit();
            
            }
        
            header('location: ./index.php?url=confirmationornot&message=article non modifié');
            exit();
        }
    }
    
    
    public function deleteProduct()
    {
        
        $this->authentificator->checkAdmin();
        $this->authentificator->csrfTokenChecker();
       
        if(!isset($_POST['id'])){
           
            header('location: ./index.php?url=confirmationornot&message=article non trouvé');
            exit();
           
        }
        
        $productId = htmlspecialchars($_POST['id']);
        
        $data = $this->repository->fetchImage( $productId);
        
        if(!unlink($data['url_picture'])){
            header('location: ./index.php?url=confirmationornot&message=article non effacé');
            exit();
        }
            
        if($this->repository->deleteProduct($productId)){
           
            header('location: ./index.php?url=confirmationornot&message=article effacé');
            exit();
       } 
                
        header('location: ./index.php?url=confirmationornot&message=article non effacé');
        exit();
        
    }        
    
    
    public function createCategory()
    {
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(isset($_POST['name'],$_FILES)){
            
            $tmpName = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $temp= explode('.',$file_name);
            $extension = end($temp);
           
            $fileName = md5(time()).'.'.$extension;
            
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
            move_uploaded_file($tmpName,'./public/assets/img/'.$fileName);
            
            $this->category->setName(htmlspecialchars($_POST['name'])) ;
            $this->category->setUrlImage("./public/assets/img/$fileName");
            
            
            if($this->categoryRepository->createCategory($this->category)){
            
                header('location: ./index.php?url=confirmationornot&message=categorie créée');
                exit();
            }
        
            header('location: ./index.php?url=confirmationornot&message=categorie non créée');
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
        $category = new Category();
        $category->setId($data['id']);
        $category->setName($data['name']);
        $category->setUrlImage($data['url_picture']);
        
        echo $this->view->displayFormModifyCategory($category);
    }
    
    
    public function modifyCategory()
    {
        
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(isset($_POST['id'],$_POST['name'],$_FILES))
        {
            
            $tmpName = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $temp= explode('.',$file_name);
            $extension = end($temp);
           
            $newFileName = md5(time()).'.'.$extension;
            
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
            
            move_uploaded_file($tmpName,'./public/assets/img/'.$newFileName);
            
            $categoryId = $_POST['id'];
            
            $data = $this->categoryRepository->fetchImage($categoryId);
           
            unlink($data['url_picture']);
            
            $this->category->setId(htmlspecialchars($_POST['id']));
            $this->category->setName(htmlspecialchars($_POST['name']));
            $this->category->setUrlImage("./public/assets/img/$newFileName");
            
            
            if($this->categoryRepository->modifyCategory($this->category)){
            
                header('location: ./index.php?url=confirmationornot&message=categorie modifiée');
                exit();
            }
            
        header('location: ./index.php?url=confirmationornot&message=categorie non modifiée');
        exit();
        
        }
    }    
    
    public function deleteCategory():void
    {
        $this->authentificator->csrfTokenChecker();
        $this->authentificator->checkAdmin();
        
        if(!isset($_POST['id'])){
            header('location: ./index.php?url=confirmationornot&message=catégorie non supprimée');
            exit();
        }    
        
        $categoryId = $_POST['id'];
        
        $data = $this->categoryRepository->fetchImage($categoryId);
       
        unlink($data['url_picture']);
        
        if($this->categoryRepository->deleteCategory($categoryId)){
        
                header('location: ./index.php?url=confirmationornot&message=catégorie supprimée');
                exit();
                
        }
        
        header('location: ./index.php?url=confirmationornot&message=catégorie non supprimée');
        exit();
    }
    
    
    public function basket() : void
    {
        
        $userAuth = $this->authentificator->checkUser();
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $datas = $this->basketRepository->findById($userAuth->getId());
       
        if(empty($datas)){
           echo $this->view->displayEmptyBasket();
           exit();
        }
        
        $prices = [];
        $products = [];
            
        foreach($datas as $data){
            $product = new Product();
            $product->setInsideBasketId($data['id']);
            $product->setName($data['name']);
            $product->setQuantity($data['quantity']);
            $product->setPrice($data['price']);
            $product->setImage($data['url_picture']);
            $product->setDescription($data['description']);
            $product->setCategory($data['category_id']);
            
            
            $products[] = $product;
            $prices[] = $product->getPrice();
        }
       
        $totalPrice = array_sum($prices);
        
        $amountAfterBuy = ($userAuth->getWallet()-$totalPrice);
        
        echo $this->view->displayBasket($products,$totalPrice,$userAuth,$amountAfterBuy);
   }
   
    public function deleteBasket() : void
    {
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
        
       
       if($this->basketRepository->deleteBasket($userAuth->getId())){
    
            header('location: ./index.php?url=confirmationornot&message=panier supprimé');
            exit();
        }
    
        header('location: ./index.php?url=confirmationornot&message=panier non supprimé');
        exit();
        
    }
    
    public function createOrder(): void 
    {
        
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
       
       if(!isset($_POST['amount_after_buy']) || $_POST['amount_after_buy']<0){
            header('location: ./index.php?url=confirmationornot&message= Fonds insufisants');
            exit();
       }
       
        $userAuth->setWallet($_POST['amount_after_buy']);
        
       
        if(!$this->UserRepository->addMoney($userAuth->getId(),$userAuth->getWallet())){
            header('location: ./index.php?url=confirmationornot&message= Commande non créée');
            exit();
        }
        
        $_SESSION['user'] = serialize($userAuth);
        
        if($datas = $this->basketRepository->findById($userAuth->getId())){
         
            foreach($datas as $data){
                 
                $this->orderRepository->createOrder($userAuth->getId(),$data['product_id']);
    
                $this->basketRepository->deleteBasket($userAuth->getId());
            }
          
         
           header('location: ./index.php?url=confirmationornot&message=votre commande à été créée');
           exit();
       }   
       
       header('location: ./index.php?url=confirmationornot&message= Commande non créée');
       exit();
    }
    
    
    public function showOrders() : void
    {
        $userAuth = $this->authentificator->checkUser();
       
        $datas = $this->orderRepository->findById($userAuth->getId());
      
        if(empty($datas)){
            
           echo $this->view->displayEmptyOrders();
           exit();
           
        }
        
        $orders = [];
           
        foreach($datas as $data){
            $order = new Order();
            $order->setCommandProductId($data['product_id']);
            $order->setCommandProductName($data['name']);
            $order->setCommandProductQuantity($data['quantity']);
            $order->setCommandProductPrice($data['price']);
            $order->setCommandProductImage($data['url_picture']);
            $order->setCommandProductDescription($data['description']);
            $order->setStatus($data['order_status']);
            
            $orders[] = $order;
           
        }
       
        echo $this->view->displayOrder($orders);
   }
   
    public function formModifyOrder()
    {
       
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
        
        if(!isset($_POST['id'])){
            header('location: ./index.php?url=confirmationornot&message=commande non modifiée');
            exit();
        }    
        
        $order = $_POST['id'];
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        echo $this->view->displayFormModifyOrder($order);
    }
       
   
    public function deleteOrder(): void
    {
        $this->authentificator->csrfTokenChecker();
        $userAuth = $this->authentificator->checkUser();
       
        
       if($this->orderRepository->deleteOrder($userAuth->getId())){
        
            header('location: ./index.php?url=confirmationornot&message=commande supprimée');
            exit();
            
       }
        header('location: ./index.php?url=confirmationornot&message=commande non supprimée');
        exit();
   }
    
}