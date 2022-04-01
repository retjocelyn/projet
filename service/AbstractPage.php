<?php 
require_once "./service/Utils.php";
require_once "./model/HeadTemplate.php";

abstract class AbstractPage {
    
    private string $page;
    
    protected HeadTemplate $head;
    
    protected string $header;
    
    protected string $body;
    
    protected string $footer;
    
    protected Utils $utils;
    
    public function __construct()
    {
        $this->utils = new Utils();
        $this->page = ''; 
        $this->head = new HeadTemplate();
        if(isset($_SESSION['user'])){
            $this->header = $this->utils->searchInc('headerconnected');
        }else{
             $this->header = $this->utils->searchInc('header');
        }
        $this->footer = $this->utils->searchInc('footer');
        
    }
    
    protected function setHeader($header = false): void
    {
        
        $this->header = $header ? $this->utils->searchInc($header) : "";
        
    }
    
    protected function setFooter($footer = false): void
    {
        $this->footer = $footer ? $this->utils->searchInc($footer) : "";
    }
    
    
    public function getPage(): string 
    {
        return $this->page;
    }
    
    
    public function constructPage(): void
    {
        $this->page .= $this->head->getContent();
        $this->page .= $this->header;
        $this->page .= $this->body;
        $this->page .= $this->footer;
        
    }
}