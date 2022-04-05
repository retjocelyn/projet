<?php 
require_once "./service/Utils.php";
require_once "./service/AbstractPage.php";

class ProductPage extends AbstractPage {
    
    private string $article;
    
    private array $products;
    
    private array $categories;
    
    public function __construct()
    {
        parent::__construct();
       
        $this->body = $this->utils->searchHtml('articles');
        $this->article = '';
        $this->products = [];
        $this->categories = [];
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
    
    
    public function constructProducts(): void
    {
       
        foreach($this->products as $product){
            $content = $this->utils->searchInc('produit');
            $content = str_replace('{%name%}', $product->getName(), $content);
            $content = str_replace('{%id%}',$product->getId(), $content);
            $content = str_replace('{%price%}',$product->getPrice(), $content);
            $content = str_replace('{%description%}',$product->getDescription(), $content);
            $content = str_replace('{%urlImage%}',$product->getImage(), $content);
          
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
                $content = str_replace('{%name%}', $product->getName(), $content);
                $content = str_replace('{%id%}',$product->getId(), $content);
                $content = str_replace('{%price%}',$product->getPrice(), $content);
                $content = str_replace('{%description%}',$product->getDescription(), $content);
                $content = str_replace('{%urlImage%}',$product->getImage(), $content);
              
                $this->article .= $content;
            }
            
            foreach($this->categories as $category){
                $content = $this->utils->searchInc('admincategory');
                $content = str_replace('{%name%}', $category->getName(), $content);
                $content = str_replace('{%id%}',$category->getId(), $content);
                $content = str_replace('{%urlImage%}',$category->getUrlImage(), $content);
              
                $categoryarticle .= $content;
            }
           
        $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);
        
        $this->body = str_replace('{%article%}', $this->article, $this->body);
        
        $this->body = str_replace('{%categories%}',$categoryarticle, $this->body);
        
        
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
    
}