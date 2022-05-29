<?php 

require_once './model/DefaultPage.php';
require_once './model/BasketPage.php';
require_once './model/OrderPage.php';



class UserView {
    
    /**
     * @return string
     */ 
    public function displayLogin(): string
    {
        $page = new DefaultPage('login');
        $page->setCsrf($_SESSION['csrf']);
        $page->setErrors('');
        if(isset($_SESSION['error'])){
            $page->setErrors($_SESSION['error']);
            unset($_SESSION['error']);
        }
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
     /**
     * @param User $user
     * @return string
     */ 
    public function displayAccount(User $user): string
    {
        $page = new DefaultPage('account');
        $page->displayAccount($user);
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
     /**
     * @param User $user
     * @return string
     */ 
    public function displayFormModifyUser(User $user):string
    {
        $page = new DefaultPage('formModifyUser');
        if(isset($_SESSION['error'])){
            $page->setErrors($_SESSION['error']);
            unset($_SESSION['error']);
        }
        $page->createFormModifyUser($user);
        return $page->getPage();
    }  
    
    /**
    * @return string
    */ 
    public function displayRegister(): string
    {
    
        $page = new DefaultPage('register');
        $page->setCsrf($_SESSION['csrf']);
        $page->setErrors('');
       
        if(isset($_SESSION['error'])){
            $page->setErrors($_SESSION['error']);
            unset($_SESSION['error']);
        }
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
    /**
    * @return string
    */ 
    public function displayRegisterAccepted(): string
    {
        $page = new DefaultPage('registerAccepted');
        $page->setMessage($_SESSION['message']);
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
     /**
     * @param array $products
     * @param float $totalPrice
     * @param User $userAuth
     * @param float $amountAfterBuy
     * @return string
     */ 
    public function displayBasket(array $products,float $totalPrice,User $userAuth,float $amountAfterBuy): string
    {
        $page = new BasketPage();
        $page->setProducts($products);
        $page->setTotalPrice($totalPrice);
        $page->setUserWallet($userAuth->getWallet());
        $page->setAmountAfterBuy($amountAfterBuy);
        $page->basketPage();
        return $page->getPage();   
    }
    
    /**
    * @return string
    */ 
    public function displayEmptyBasket()
    {
        $page = new BasketPage();
        $page->emptyBasketPage();
        return $page->getPage();   
    }
    
    /**
     * @param array $orders
     * @return string
     */ 
    public function displayOrder(array $orders):string
    {
        $page = new orderPage();
        $page->setOrders($orders);
        $page->orderPage();
        return $page->getPage();   
    }
    
    /**
    * @return string
    */ 
    public function displayEmptyOrders():string
    {
        $page = new orderPage();
        $page->emptyOrdersPage();
        return $page->getPage();   
    }
}