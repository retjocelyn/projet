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
    
   
    
}