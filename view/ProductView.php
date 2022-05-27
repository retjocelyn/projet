<?php 

require_once './model/ProductPage.php';


class ProductView {
    
    /**
     * @return string
     */ 
    
    
    public function dislplayInstruments($products):string
    {
        $page = new ProductPage();
        $page->setProducts($products);
        $page->constructProducts();
        return $page->getPage();
    }
    
    public function displayadminAccount(array $products,array $categories,array $commandes, array $users):string
    {
        $page = new ProductPage();
        $page->setProducts($products);
        $page->setCategories($categories);
        $page->setOrders($commandes);
        $page->setUsers($users);
        $page->adminAccountPage();
        return $page->getPage();
    }
    
    public function displayFormModifyProduct(Product $product,array $categories)
    {
        $page = new ProductPage();
        $page->setCategories($categories);
        $page->CreateFormModifyProduct($product);
        return $page->getPage();   
    }
    
    public function displayFormModifyCategory(Category $category)
    {
        $page = new ProductPage();
        $page->CreateFormModifyCategory($category);
        return $page->getPage();   
    }
    
    public function displayFormModifyOrder($order):string
    {
        $page = new ProductPage();
        $page->CreateFormModifyOrder($order);
        return $page->getPage();   
    }
    
    
    public function displayOneProduct(Product $product)
    {
        $page = new ProductPage();
        $page->displayOneProduct($product);
        return $page->getPage();  
    }
    
    public function displayBasket(array $products,float $totalPrice, User $userAuth,float $amountAfterBuy)
    {
        $page = new ProductPage();
        $page->setProducts($products);
        $page->setTotalPrice($totalPrice);
        $page->setUserWallet($userAuth->getWallet());
        $page->setAmountAfterBuy($amountAfterBuy);
        $page->basketPage();
        return $page->getPage();   
    }
    public function displayEmptyBasket()
    {
        $page = new ProductPage();
        $page->emptyBasketPage();
        return $page->getPage();   
    }
    
    public function displayOrder(array $orders):string
    {
        $page = new ProductPage();
        $page->setOrders($orders);
        $page->orderPage();
        return $page->getPage();   
    }
    
    public function displayEmptyOrders():string
    {
        $page = new ProductPage();
        $page->emptyOrdersPage();
        return $page->getPage();   
    }
    
}