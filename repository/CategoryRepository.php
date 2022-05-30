<?php

require_once './repository/AbstractRepository.php';

 class CategoryRepository extends AbstractRepository
{
    
    public function findAll(): array
    {
        $data = null; 
        
        try {
            $query = $this->connexion->query('SELECT * FROM category');
            
            if ($query) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
    public function findById(int $categoryId):array
    {
        $data = null; 
        
        try {
             $query = $this->connexion->prepare('SELECT * FROM category WHERE id = :id');
            if ($query) {
                $query->bindParam(':id', $categoryId);
                $query->execute();
                
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
    public function fetchImage(int $categoryId):array
    {
        $data = null;
        
        try {
            $query = $this->connexion->prepare('SELECT url_picture FROM category WHERE id = :id');
            if ($query) {
                $query->bindParam(':id', $categoryId);
                $query->execute();
                
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
    public function createCategory(Category $newCategory):bool
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
    
    
    public function modifyCategory(Category $newCategory):bool
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
    
    
    public function deleteCategory(int $id):bool
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