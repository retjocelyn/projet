<?php

require_once './repository/AbstractRepository.php';

 class OrderRepository extends AbstractRepository
{
    
    private const TABLE = "orders";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    
    public function findAll() /*doute si utile???*/
    {
        $data = null;
        
        try {
            $query = $this->connexion->prepare('SELECT * FROM orders ');
            
            if ($query) {
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    public function findAllOrders()
    {  
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT o.id, o.user_id, o.created_at,
            u.first_name, u.last_name, u.adress, p.name, p.quantity,p.url_picture , p.price
            FROM orders as o INNER JOIN users as u ON o.user_id = u.id 
            INNER JOIN products as p ON o.product_id = p.id');
            
            if ($query) {
                $query->execute();
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    public function createOrder($userId,$productId)
    {  
        
            try {
                $query = $this->connexion->prepare('INSERT INTO orders
                    (user_id,product_id,created_at) 
                    VALUES (:userId,:productId, NOW())');
                
                if ($query) {   
               
                    $query->bindValue(':userId', $userId);
                    $query->bindValue(':productId',$productId);
                    
                     return $query->execute();
                }    
                
            } catch (Exception $e) {
                return false;
        }
        
    }
    
    public function findById($userid)
    {
        $data = null;
        
        try {                                  
            $query = $this->connexion->prepare('SELECT * FROM products as p 
                INNER JOIN orders as ord ON p.id = ord.product_id 
                WHERE ord.user_id = :id');
                
            if ($query) {
                
                $query->bindParam(':id', $userid);
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    public function deleteOrder($userId)
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
      
    
    public function adminDeleteOrder($orderId):bool
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