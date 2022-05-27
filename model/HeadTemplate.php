<?php 
require_once "./service/Utils.php";

class HeadTemplate {
    
    
    private string $content;
    
    private string $title;
    
    private string $description;
    
    private Utils $utils;
    
    public function __construct()
    {
        $this->utils = new Utils();
        $this->title = "symphony";
        $this->description = "notre super boutique";
        $this->constructHead();
    }
    
    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
    
    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
        $this->constructHead();
    }
    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
        $this->constructHead();
    }
    
    /**
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->constructHead();
    }
    
    
    private function constructHead(): void
    {
        $this->content = $this->utils->searchInc('head');
        $this->content = str_replace('{%title%}', $this->title, $this->content);
        $this->content = str_replace('{%description%}', $this->description, $this->content);
    }
}