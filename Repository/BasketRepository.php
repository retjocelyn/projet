<?php

require_once './Repository/AbstractRepository.php';

 class BasketRepository extends AbstractRepository
{
    
    private const TABLE = "panier";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
   
        public function addArticle($article,$user): void
    {
        $sql = "INSERT INTO panier () VALUES ('$newfirstName', NOW())";
        $stmt = $this->connexion->query($sql);
       
    }
    
    
    
}