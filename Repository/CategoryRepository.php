<?php

require_once './Repository/AbstractRepository.php';

 class CategoryRepository extends AbstractRepository
{
    
    private const TABLE = "category";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
   
    
    public function findAll()
    {
        $data = null; 
        try {
            $query = $this->connexion->query('SELECT * FROM category');
            if ($query) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
     public function createCategory($newCategoryName,$newCategoryImage){
        $sql = "INSERT INTO category (name,url_picture) VALUES ('$newCategoryName','$newCategoryImage')";
        $stmt = $this->connexion->query($sql);
     }
    

}