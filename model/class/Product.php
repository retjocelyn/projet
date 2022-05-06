<?php

class Product {

    
    private int $id;

    private int $insideBasketId;
    
    private string $name;
    
    private string $description;
    
    private int $price;
    
    private string $category;
    
    private string $image;
    
    private int $quantity;
    
    
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
     * @return int
     */
    public function getInsideBasketId(): int
    {
        return $this->insideBasketId;
    }
    
    /**
     * @param int $insideBasketId
     */
    public function setInsideBasketId(int $insideBasketId): void
    {
        $this->id = $insideBasketId;
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
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     */
    public function setDescription(string $description):void
    {
        $this->description = $description;
    }
    
    
     /**
     * @return int 
     */
      public function getPrice(): int
    {
        return $this->price;
    }
    
    /**
     * @param int $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }
    
    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }
    
    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }
    
    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
    
    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    
     /**
     * @return int
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }
    
    /**
     * @param string $quantity
     */
    public function setQuantity(string $quantity): void
    {
        $this->quantity = $quantity;
    }
}