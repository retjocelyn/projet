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
    
    public function displayShop(array $categories): string
    {
        
        $page = new ShopPage();
        $page->setCategories($categories);
        $page->constructShop();
        return $page->getPage();
       
    }
    
    public function displayConfirmationOrNot(): string
    {
        $page = new DefaultPage('confirmationOrNot');
        $message = $_SESSION['message'];
        $page->setErrors($message);
        $page->assemblerPage();
        return $page->getPage();
       
    }
}

// notion.