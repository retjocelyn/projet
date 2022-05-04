<?php

require_once './repository/AbstractRepository.php';

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
    
    public function findById($category)
    {
        $data = null; 
        try {
             $query = $this->connexion->prepare('SELECT * FROM category WHERE id = :id');
            if ($query) {
                $query->bindParam(':id', $category);
                $query->execute();
                
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    
    public function createCategory($newCategory):bool
    {
       
        try{
             $query = $this->connexion->prepare('INSERT INTO category (name,url_picture) 
                VALUES (:categoryName,:categoryImage)');

            if ($query) {
               
                $query->bindValue(':categoryName',$newCategory->getName());
                $query->bindValue(':categoryImage',$newCategory->getUrlImage());
                
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
    
    
    public function modifyCategory($newCategory):bool
    {
       
        try{
             $query = $this->connexion->prepare('UPDATE category
                SET name = :newCategoryName,url_picture = :newCategoryImage
                WHERE id = :categoryId');

            if ($query) {
               
                $query->bindValue(':newCategoryName',$newCategory->getName());
                $query->bindValue(':newCategoryImage',$newCategory->getUrlImage());
                $query->bindValue(':categoryId',$newCategory->getId());
                
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
    
    
    public function deleteCategory($id):bool
    {
         
        try{
             $query = $this->connexion->prepare('DELETE FROM category
                WHERE id = :categoryId');

            if ($query) {
               
                $query->bindValue(':categoryId',$id);
                
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
    

}