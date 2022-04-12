<?php 
require_once './view/HomeView.php';
require_once './Repository/CategoryRepository.php';
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
}