<?php 

require_once './model/DefaultPage.php';
require_once './model/ShopPage.php';


class HomeView {
    
    /**
     * @return string
     */ 
    public function displayHome(): string
    {
        $page = new DefaultPage('home');
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
    public function displayShop($categories): string
    {
        $page = new ShopPage();
        $page->setCategories($categories);
        $page->constructShop();
        return $page->getPage();
       
    }
}

// notion.