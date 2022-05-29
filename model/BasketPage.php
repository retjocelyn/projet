<?php 
require_once "./service/Utils.php";
require_once "./service/AbstractPage.php";

class BasketPage extends AbstractPage{
   
    private string $article;
    
    private array $products;
    
    private float  $totalprice;
    
    private float $userWallet;
    
    private float $amountAfterBuy;
    
    public function __construct()
    {
        parent::__construct();
       
        $this->article = '';
        $this->products = [];
        $this->categories = [];
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
     
     
   
}