<?php 
require_once "./service/Utils.php";
require_once "./service/AbstractPage.php";

class ProductPage extends AbstractPage {
    
    private string $article;
    
    private array $products;
    
    private array $categories;
    
    private array $orders;
    
    private int  $totalprice;
    
    private array $users;
    
    public function __construct()
    {
        parent::__construct();
       
        $this->body = $this->utils->searchHtml('articles');
        $this->article = '';
        $this->products = [];
        $this->categories = [];
        $this->orders = [];
        $this->totalprice = 0;
    }
    
    
    /**
     * @return string
     */
    public function getArticle(): string
    {
        return $this->article;
    }
    
    /**
     * @param string $article
     */
    public function setArticle(string $article)
    {
        $this->article = $article;
    }
    
    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }
    
    /**
     * @param array $products
     */
    public function setProducts(array $products)
    {
        $this->products = $products;
    }
    
    public function getCategories(): array
    {
        return $this->categories;
    }
    
    /**
     * @param array $categories
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }
    
    
     /**
     * @return array
     */
     public function getOrders(): array
    {
        return $this->orders;
    }
    
    
    /**
     * @param array $orders
     */
    public function setOrders(array $orders)
    {
        $this->orders = $orders;
    }
    
   
    
     /**
     * @return int
     */
     public function getTotalPrice(): int
    {
        return $this->totalprice;
    }
    
    /**
     * @param array $categories
     */
    public function setTotalPrice( int $totalprice)
    {
        $this->totalprice = $totalprice;
    }
    
     /**
     * @param array $products
     */
    public function setUsers(array $users)
    {
        $this->users = $users;
    }
    
    public function getUsers(): array
    {
        return $this->users;
    }
    
    public function constructProducts(): void
    {
       
        foreach($this->products as $product){
            $content = $this->utils->searchInc('produit');
            $content = str_replace('{%name%}', $product->getName(), $content);
            $content = str_replace('{%id%}',$product->getId(), $content);
            $content = str_replace('{%price%}',$product->getPrice(), $content);
            $content = str_replace('{%description%}',$product->getDescription(), $content);
            $content = str_replace('{%quantity%}',$product->getQuantity(), $content);
            $content = str_replace('{%urlImage%}',$product->getImage(), $content);
            $content = str_replace('{%$token%}',$_SESSION["csrf"], $content);
          
            $this->article .= $content;
        }
        
        $this->body = str_replace('{%article%}', $this->article, $this->body);
        
        $this->constructPage();
    }
    
    public function adminAccountPage()
     {
            $this->head->setTitle('page admin');
            $this->head->setDescription('admin');
            $this->body = $this->utils->searchHtml('adminaccount');
            $categoryarticle = '';
            foreach($this->products as $product){
                $content = $this->utils->searchInc('adminProduct');
                $content = str_replace('{%name%}', $product->getName(),$content);
                $content = str_replace('{%id%}',$product->getId(),$content);
                $content = str_replace('{%quantity%}',$product->getQuantity(),$content);
                $content = str_replace('{%price%}',$product->getPrice(), $content);
                $content = str_replace('{%description%}',$product->getDescription(),$content);
                $content = str_replace('{%urlImage%}',$product->getImage(),$content);
                $content = str_replace('{%$token%}',$_SESSION["csrf"], $content);
              
                $this->article .= $content;
            }
            
            foreach($this->categories as $category){
                $content = $this->utils->searchInc('admincategory');
                $content = str_replace('{%name%}', $category->getName(), $content);
                $content = str_replace('{%id%}',$category->getId(), $content);
                $content = str_replace('{%urlImage%}',$category->getUrlImage(), $content);
                $content = str_replace('{%$token%}',$_SESSION["csrf"], $content);
              
                $categoryarticle .= $content;
            }
            
            $allCategories = '';
            foreach($this->categories as $category){
                $content = $this->utils->searchInc('category');
                $content = str_replace('{%name%}', $category->getName(), $content);
                $content = str_replace('{%id%}',$category->getId(), $content);
                $content = str_replace('{%urlImage%}',$category->getUrlImage(), $content);
                
              
                $allCategories .= $content;
            }
            
            $commandArticle = '';
            foreach($this->orders as $order){
                $content = $this->utils->searchInc('admincommandes');
                $content = str_replace('{%numerodelacommande%}',$order->getId(),$content);
                $content = str_replace('{%id%}',$order->getId(),$content);
                $content = str_replace('{%datedelacommande%}',$order->getDate(),$content);
                $content = str_replace('{%clientfamilyname%}',$order->getCommandUserFamilyName(),$content);
                $content = str_replace('{%clientname%}',$order->getCommandUserName(),$content);
                $content = str_replace('{%clientadresse%}',$order->getCommandUserAdress(),$content);
                $content = str_replace('{%urlImage%}',$order->getCommandProductImage(),$content);
                $content = str_replace('{%nameproduit%}',$order->getCommandProductName(),$content);
                $content = str_replace('{%quantity%}',$order->getCommandProductQuantity(),$content);
                $content = str_replace('{%price%}',$order->getCommandProductPrice(),$content);
                $content = str_replace('{%$token%}',$_SESSION["csrf"], $content);
            
                $commandArticle .=  $content;
            }
            
            $adminUsers = '';
            foreach($this->users as $user){
                $content = $this->utils->searchInc('adminusers');
                $content = str_replace('{%name%}',$user->getFirstName(),$content);
                $content = str_replace('{%familyname%}',$user->getlastName(),$content);
                $content = str_replace('{%id%}',$user->getId(),$content);
                $content = str_replace('{%$token%}',$_SESSION["csrf"], $content);
            
                $adminUsers .= $content;
            }
            
           
            $this->body = str_replace('{%$token%}', $_SESSION['csrf'],$this->body);
            
            $this->body = str_replace('{%article%}', $this->article,$this->body);
            
            $this->body = str_replace('{%commandes%}', $commandArticle,$this->body);
            
            $this->body = str_replace('{%option%}', $allCategories,$this->body);
            
            $this->body = str_replace('{%users%}', $adminUsers,$this->body);
            
            $this->body = str_replace('{%categories%}',$categoryarticle,$this->body);

            $this->constructPage();
     }
     
    public function displayOneProduct($product)
    {
        $this->head->setTitle('page produit');
        $this->head->setDescription('affiche un produit');
        $this->body = $this->utils->searchHtml('oneproduct');
        
        $content = $this->utils->searchInc('produit');
        $content = str_replace('{%name%}', $product->getName(), $content);
        $content = str_replace('{%id%}',$product->getId(), $content);
        $content = str_replace('{%price%}',$product->getPrice(), $content);
        $content = str_replace('{%description%}',$product->getDescription(), $content);
        $content = str_replace('{%quantity%}',$product->getQuantity(), $content);
        $content = str_replace('{%urlImage%}',$product->getImage(), $content);
        $content = str_replace('{%$token%}',$_SESSION["csrf"], $content);
        
        $this->body = str_replace('{% article %}',$content,$this->body);
        
        $this->constructPage();
    }
     
    public function CreateFormModifyProduct($product)
    {
            
            $this->head->setTitle('symphony: page modifer produit');
            $this->head->setDescription('modifier produit');
            $this->body = $this->utils->searchHtml('formmodifyproduct');
            
            foreach($this->categories as $category){
                 $content = $this->utils->searchInc('category');
                 $content = str_replace('{%name%}', $category->getName(), $content);
                 $content = str_replace('{%id%}', $category->getId(), $content);
                 
                 $this->article .= $content;
            }
           
            $this->body = str_replace('{%option%}', $this->article, $this->body);
            $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
            $this->body = str_replace('{%name%}',$product->getName(), $this->body);
            $this->body = str_replace('{%description%}',$product->getDescription(), $this->body);
            $this->body = str_replace('{%price%}',$product->getPrice(),$this->body);
            $this->body = str_replace('{%quantity%}',$product->getQuantity(), $this->body);
            $this->body = str_replace('{%id%}',$product->getId(), $this->body);
            
            $this->constructPage();
            
    }
    
    public function CreateFormModifyCategory($category)
    {
            $this->head->setTitle('symphony: page modifer category');
            $this->head->setDescription('modifier produit');
            $this->body = $this->utils->searchHtml('formmodifycategory');
            $this->body = str_replace('{%name%}',$category->getName(), $this->body);
            $this->body = str_replace('{%id%}',$category->getId(), $this->body);
            $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
             
            $this->constructPage();
     }
     
    public function CreateFormModifyOrder($order)
    {
        $this->head->setTitle('symphony: page modifer commande');
        $this->head->setDescription('modifier commande');
        $this->body = $this->utils->searchHtml('formmodifyorder');
        $this->body = str_replace('{%id%}',$order, $this->body);
        $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
         
        $this->constructPage();
    }
     
    public function basketPage()
    {
        $this->head->setTitle('symphony: panier');
        $this->head->setDescription('votre panier');
        $this->body = $this->utils->searchHtml('basket');
        $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
       
        foreach($this->products as $product){
                $content = $this->utils->searchInc('produitbasket');
                $content = str_replace('{%name%}', $product->getName(), $content);
                $content = str_replace('{%id%}',$product->getId(), $content);
                $content = str_replace('{%price%}',$product->getPrice(), $content);
                $content = str_replace('{%quantity%}',$product->getQuantity(), $content);
                $content = str_replace('{%description%}',$product->getDescription(), $content);
                $content = str_replace('{%urlImage%}',$product->getImage(), $content);
                $content = str_replace('{%$token%}', $_SESSION['csrf'], $content);
                
                $this->article .= $content;
            }
        
        $content = $this->utils->searchInc('prix');
        $content = str_replace('{%prixtotal%}',$this->getTotalPrice(), $content);
        $this->body = str_replace('{%prixtotal%}',$content, $this->body);
        $this->body = str_replace('{%message%}','', $this->body);
        $this->body = str_replace('{%article%}',$this->article, $this->body);
         
        
        $this->constructPage();
     }
     
     public function emptyBasketPage()
     {
        $this->head->setTitle('symphony: panier');
        $this->head->setDescription('votre panier');
        $this->body = $this->utils->searchHtml('emptybasket');
        $this->constructPage();
     }
     
      public function orderPage()
    {
        $this->head->setTitle('symphony: commandes');
        $this->head->setDescription('votre commandes');
        $this->body = $this->utils->searchHtml('order');
        $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
    
        foreach($this->orders as $order){
          
                $content = $this->utils->searchInc('produitorder');
                $content = str_replace('{%name%}', $order->getCommandProductName(), $content);
                $content = str_replace('{%id%}',$order->getCommandProductId(), $content);
                $content = str_replace('{%price%}',$order->getCommandProductPrice(),$content);
                $content = str_replace('{%quantity%}',$order->getCommandProductQuantity(), $content);
                $content = str_replace('{%description%}',$order->getCommandProductDescription(), $content);
                $content = str_replace('{%status%}',$order->getStatus(), $content);
                $content = str_replace('{%urlImage%}',$order->getCommandProductImage(), $content);
                
                $this->article .= $content;
            }
        
        $this->body = str_replace('{%message%}','', $this->body);
        $this->body = str_replace('{%id%}','', $this->body);
        $this->body = str_replace('{%article%}',$this->article, $this->body);
         
        $this->constructPage();
        
     }
     
     public function emptyOrdersPage()
     {
        $this->head->setTitle('symphony: commandes');
        $this->head->setDescription('votre commandes');
        $this->body = $this->utils->searchHtml('emptyorders');
        $this->constructPage();
     }
    
}