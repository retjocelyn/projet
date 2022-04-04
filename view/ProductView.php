<?php 

require_once './model/ProductPage.php';


class ProductView {
    
    /**
     * @return string
     */ 
    
    
    public function dislplayInstruments($products): string
    {
        $page = new ProductPage();
        $page->setProducts($products);
        $page->constructProducts();
        return $page->getPage();
    }
    
    public function displayadminAccount($products)
    {
        $page = new ProductPage();
        $page->setProducts($products);
        $page->adminAccountPage();
        return $page->getPage();
    }
    
    public function displayFormModifyProduct($product)
    {
        $page = new ProductPage();
        $page-> CreateFormModifyProduct($product);
        return $page->getPage();   
    }
    
}