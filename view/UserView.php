<?php 

require_once './model/DefaultPage.php';


class UserView {
    
    /**
     * @return string
     */ 
    public function displayLogin(): string
    {
        $page = new DefaultPage('login');
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
        $page->assemblerPage();
        return $page->getPage();
       
    }
    
    public function displayRegisterAccepted(): string
    {
        $page = new DefaultPage('registeraccepted');
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