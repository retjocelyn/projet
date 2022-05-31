<?php 
require_once './view/HomeView.php';
require_once './repository/CategoryRepository.php';
require_once './model/class/Category.php';

class HomeController {
    
    private $view;
    
    public function __construct(){
        $this->view = new HomeView();
    }
    
    
    public function home()
    {
       echo $this->view->displayHome();
    }
    
     public function shop()
     {
         $repository = new CategoryRepository();
         $datas = $repository->findAll();
         
        if(isset($datas['error'])){
            header('location:./index.php?url=confirmationOrNot&message=Une erreur est survenue');
            exit();
        }
        
         $categories = [];
        
         foreach($datas as $data){
             $category = new Category();
             $category->setName($data['name']);
             $category->setId($data['id']);
             $category->setUrlImage($data['url_picture']);
             
             $categories[] = $category;
         }
       echo $this->view->displayShop($categories);
    }
    
    /*Affiche message de confirmation ou une erreur*/
    
    public function confirmationOrNot():void
    {
        if(isset($_GET['message'])){
            $_SESSION['message'] = $_GET['message'];
        }else{
            $_SESSION['message'] = 'erreur';
        }
        
        
        echo $this->view->displayConfirmationOrNot();
    }
}