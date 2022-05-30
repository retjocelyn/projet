<?php 
require_once "./service/Utils.php";
require_once "./service/AbstractPage.php";

class OrderPage extends AbstractPage {
    
    private string $article;
    
    private array $orders;
    
    public function __construct()
    {
        parent::__construct();
       
        $this->body = $this->utils->searchHtml('articles');
        $this->article = '';
        $this->products = [];
        $this->categories = [];
        $this->orders = [];
        $this->totalprice = 0;
        $this->userWallet = 0;
    }
    
    
    /**
     * @return string $article
     */
    public function getArticle(): string
    {
        return $this->article;
    }
    
    /**
     * @param string $article
     */
    public function setArticle(string $article): void
    {
        $this->article = $article;
    }
    
    /**
     * @return array $orders
     */
     public function getOrders(): array
    {
        return $this->orders;
    }
    
    /**
     * @param array $orders
     */
    public function setOrders(array $orders): void
    {
        $this->orders = $orders;
    }
   
    public function orderPage(): void
    {
        
        $this->head->setTitle('symphonie: commandes');
        $this->head->setDescription('votre commandes');
        $this->body = $this->utils->searchHtml('order');
        $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
    
        foreach($this->orders as $order){
            $content = $this->utils->searchInc('produitOrder');
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
     
    public function emptyOrdersPage(): void
    {
        $this->head->setTitle('symphonie: commande vide');
        $this->head->setDescription('Commande vide');
        $this->body = $this->utils->searchHtml('emptyOrders');
        $this->constructPage();
    }
     
    
}