<?php 
require_once "./service/Utils.php";
require_once "./service/AbstractPage.php";

class OrderPage extends AbstractPage {
    
    private string $article;
    
    private array $products;
    
    private array $categories;
    
    private array $orders;
    
    private float  $totalprice;
    
    private array $users;
    
    private float $userWallet;
    
    private float $amountAfterBuy;
    
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
     * @return array $products
     */
    public function getProducts(): array
    {
        return $this->products;
    }
    
    /**
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }
    
     /**
     * @return array $categories
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
    
    /**
     * @param array $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
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
    
     /**
     * @return float $totalPrice
     */
     public function getTotalPrice(): float
    {
        return $this->totalprice;
    }
    
    /**
     * @param float $totalPrice
     */
    public function setTotalPrice(float $totalprice): void
    {
        $this->totalprice = $totalprice;
    }
    
     /**
     * @return float $userWallet
     */
    public function getUserWallet(): float
    {
        return $this->userWallet;
    }
    
    /**
     * @param float $userWallet
     */
    public function setUserWallet(float $userWallet): void
    {
        $this->userWallet = $userWallet;
    }
    
     /**
     * @return array $users
     */
    public function getUsers(): array
    {
        return $this->users;
    }
    
     /**
     * @param array $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }
    
     /**
     * @return float $amountAfterBuy
     */
    public function getAmountAfterBuy(): float
    {
        return $this->amountAfterBuy;
    }
    
    /**
     * @param float $amountAfterBuy
     */
    public function setAmountAfterBuy(float $amountAfterBuy): void
    {
        $this->amountAfterBuy = $amountAfterBuy;
    }
    
    public function CreateFormModifyProduct(Product $product): void 
    {
            
            $this->head->setTitle('symphonie: page modifer produit');
            $this->head->setDescription('modifier produit');
            $this->body = $this->utils->searchHtml('formModifyProduct');
            
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
    
    public function CreateFormModifyCategory(Category $category): void 
    {
            $this->head->setTitle('symphonie: page modifer category');
            $this->head->setDescription('modifier produit');
            $this->body = $this->utils->searchHtml('formModifyCategory');
            $this->body = str_replace('{%name%}',$category->getName(), $this->body);
            $this->body = str_replace('{%id%}',$category->getId(), $this->body);
            $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
             
            $this->constructPage();
     }
     
    public function CreateFormModifyOrder(string $order): void
    {
        $this->head->setTitle('symphonie: page modifer commande');
        $this->head->setDescription('modifier commande');
        $this->body = $this->utils->searchHtml('formModifyOrder');
        $this->body = str_replace('{%id%}',$order, $this->body);
        $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
         
        $this->constructPage();
    }
     
    public function basketPage(): void
    {
        $this->head->setTitle('symphonie: panier');
        $this->head->setDescription('votre panier');
        $this->body = $this->utils->searchHtml('basket');
        $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
       
        foreach($this->products as $product){
            $content = $this->utils->searchInc('produitBasket');
            $content = str_replace('{%name%}', $product->getName(), $content);
            $content = str_replace('{%id%}',$product->getId(), $content);
            $content = str_replace('{%price%}',$product->getPrice(), $content);
            $content = str_replace('{%quantity%}',$product->getQuantity(), $content);
            $content = str_replace('{%description%}',$product->getDescription(), $content);
            $content = str_replace('{%urlImage%}',$product->getImage(), $content);
            $content = str_replace('{%$token%}', $_SESSION['csrf'], $content);
            
            $this->article .= $content;
        }
        
       
        $this->body = str_replace('{%prixtotal%}',$this->getTotalPrice(),$this->body);
        $this->body = str_replace('{%solde%}',$this->getUserWallet(), $this->body);
        $this->body = str_replace('{%message%}','', $this->body);
        $this->body = str_replace('{%article%}',$this->article, $this->body);
        $this->body = str_replace('{%amount_after_buy%}',$this->getAmountAfterBuy(), $this->body); 
        
        $this->constructPage();
    }
     
    public function emptyBasketPage(): void
    {
        $this->head->setTitle('symphonie: panier');
        $this->head->setDescription('votre panier');
        $this->body = $this->utils->searchHtml('emptyBasket');
        $this->constructPage();
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