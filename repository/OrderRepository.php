<?php

require_once './repository/AbstractRepository.php';

 class OrderRepository extends AbstractRepository
{
    
    public function findAll(): array
    {
        $data = null;
        
        try {
            $query = $this->connexion->prepare('SELECT * FROM orders ');
            
            if ($query) {
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
    public function findAllOrders():array
    {  
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT o.id, o.user_id, o.created_at,stat.order_status,
            u.first_name, u.last_name, u.adress, p.name, p.quantity,p.url_picture , p.price
            FROM orders as o INNER JOIN users as u ON o.user_id = u.id 
            INNER JOIN status as stat ON o.status_id = stat.id 
            INNER JOIN products as p ON o.product_id = p.id');
            
            if ($query) {
                $query->execute();
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
    public function createOrder(int $userId, int$productId):bool
    {  
        
            try {
                $query = $this->connexion->prepare('INSERT INTO orders
                    (user_id,product_id,created_at,status_id) 
                    VALUES (:userId,:productId, NOW(),:status_id)');
                
                if ($query) {   
               
                    $query->bindValue(':userId', $userId);
                    $query->bindValue(':productId',$productId);
                    $query->bindValue(':status_id',1);
                    
                     return $query->execute();
                }    
                
            } catch (Exception $e) {
                return false;
        }
        
    }
    
    public function findById(int $userid):array
    {
        $data = null;
        
        try {                                  
            $query = $this->connexion->prepare('SELECT * FROM products as p 
                INNER JOIN orders as ord ON p.id = ord.product_id 
                INNER JOIN status as stat ON ord.status_id = stat.id 
                WHERE ord.user_id = :id');
                
            if ($query) {
                
                $query->bindParam(':id', $userid);
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
    public function deleteOrder(int $userId):bool
    {  
        
         try {
                $query = $this->connexion->prepare('DELETE FROM orders WHERE user_id = :userId');
                if ($query) {   
               
                    $query->bindValue(':userId', $userId);
                    
                    return $query->execute();
                }    
                
            } catch (Exception $e) {
                return false;
        }
        
    }
    
     public function adminModifyOrder(int $orderId, int $statusId):bool
     {
        try{
             $query = $this->connexion->prepare('UPDATE orders
                SET status_id = :statusId
                WHERE id = :orderId');
            
            if ($query) {
               
                $query->bindValue(':orderId',$orderId);
                $query->bindValue(':statusId',$statusId);
                
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
      
    
    public function adminDeleteOrder(int $orderId):bool
    {  
       
        try {
            $query = $this->connexion->prepare('DELETE FROM orders WHERE id = :orderId');
                if ($query) {   
               
                    $query->bindValue(':orderId',$orderId);
                    
                    return $query->execute();
                }    
                
            } catch (Exception $e) {
                return false;
            }
    }
      
}