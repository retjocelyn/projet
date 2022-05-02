<?php 

require_once './model/DefaultPage.php';


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
    
    public function displayAccount($user): string
    {
        $page = new DefaultPage('account');
        $page->displayAccount($user);
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
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
    
    
    public function displayRegisterAccepted(): string
    {
        $page = new DefaultPage('registeraccepted');
        $page->setMessage($_SESSION['message']);
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
    public function displayConfirmationOrNot(): string
    {
        $page = new DefaultPage('confirmationornot');
        $message = $_SESSION['message'];
        $page->setErrors($message);
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
    public function displayBasket(): string
    {
        $page = new DefaultPage('basket');
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
    public function displayFormModifyUser($user):string
    {
        $page = new DefaultPage('formmodifyuser');
        $page->createFormModifyUser($user);
        return $page->getPage();
    }
    
    
}