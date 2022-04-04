<?php 
require_once "./service/Utils.php";
require_once "./service/AbstractPage.php";

class DefaultPage extends AbstractPage {
    
    private string $html;
    
    private array $errors;
    
    private array $data;
    
    private string $csrf;
    
    
    public function __construct(string $html)
    {
        parent::__construct();
        
        $this->html = $html;
        $this->body = $this->utils->searchHtml($html);
    }
    
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }
    
    public function getCsrf(): string
    {
        return $this->csrf;
    }
    
    public function setCsrf($csrf): void
    {
        $this->csrf = $csrf;
    }
    
    
    public function assemblerPage(): void 
    {
        switch($this->html){
            case 'home' : 
            $this->head->setTitle('symphony: page accueil');
            $this->head->setDescription('accueil');
            $this->constructPage();
            break;
                
                
            case'login':
            $this->head->setTitle('symphony: page connexion');
            $this->head->setDescription('formulaire connexion');    
            $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body); 
            $this->constructPage();
            break;
            
            case'account':
            $user = unserialize($_SESSION['user']); 
            $this->head->setTitle('symphony: page compte');
            $this->head->setDescription('compte');
            $this->body = str_replace('{%nom%}', $user->getLastName(), $this->body);
            $this->body = str_replace('{%prenom%}', $user->getFirstName(), $this->body);
            $this->body = str_replace('{%email%}', $user->getEmail(), $this->body);
            $this->body = str_replace('{%adresse%}', $user->getAdresse(), $this->body);
            $this->body = str_replace('{%solde%}', $user->getWallet(), $this->body);
            $this->constructPage();
            
            break;
            
            case'register':
            $this->head->setTitle('symphony: page inscription');
            $this->head->setDescription('inscription');
            $this->body = str_replace('{%$token%}', $_SESSION['csrf'], $this->body);    
            $this->constructPage();
            break;
            
            case'registeraccepted':
            $this->head->setTitle('symphony: page inscription');
            $this->head->setDescription('inscription');
            $this->constructPage();
            break;
                
            case'shop':
            $this->head->setTitle('symphony: page catégories');
            $this->head->setDescription('catégories');
            $this->constructPage();
            break;    
                
                  
            case'basket':
            $this->head->setTitle('symphony: page panier');
            $this->head->setDescription('panier');
            $this->constructPage();
            break;    
            
        }
        
    }
    
    
}