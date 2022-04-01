<?php

class Category {

    
    private int $id;
    
    private string $name;
    
    private string $urlimage;
    
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id 
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getUrlImage(): string
    {
        return $this->urlimage;
    }
    
    /**
     * @param string $urlimage
     */
    public function setUrlImage(string $urlimage): void
    {
        $this->urlimage = $urlimage;
    }
}