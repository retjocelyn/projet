<?php

require_once './repository/AbstractRepository.php';

class BasketRepository extends AbstractRepository
{
    public function findById(int $userId) 
    {
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM products as p INNER JOIN panier as pa ON p.id = pa.product_id WHERE pa.user_id = :id');
            if ($query) {
                $query->bindParam(':id', $userId);
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        return $data;
    }
    
    public function addArticleToBasket(int $userId,int $productId): bool
    {
       
        try {
            $query = $this->connexion->prepare('INSERT INTO `panier`( `user_id`, `product_id`, `created_at`) 
            VALUES (:userId,:productId,NOW())');
            if ($query) {
                $query->bindParam(':userId', $userId);
                $query->bindParam(':productId', $productId);
               
               return $query->execute();
            }    
        } catch (Exception $e) {
            return false;
        }
        
    }
    
    public function deleteArticleFromBasket(int $ArticleBasketId): bool
    {
       
        try {
            $query = $this->connexion->prepare('DELETE FROM `panier` 
            WHERE id = :articleBasketId');
            
            if ($query) {
                $query->bindParam(':articleBasketId', $ArticleBasketId);
                
               
               return $query->execute();
            }    
        } catch (Exception $e) {
            return false;
        }
        
    }
    
    
    public function deleteBasket(int $userId): bool
    {
       
         try {
            $query = $this->connexion->prepare('DELETE FROM `panier` 
            WHERE  user_id = :userId  ');
            
            if ($query) {
                $query->bindParam(':userId', $userId);
               
               return $query->execute();
            }    
        } catch (Exception $e) {
            return false;
        }
        
    }
    
    
}