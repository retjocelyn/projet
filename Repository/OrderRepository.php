<?php

require_once './Repository/AbstractRepository.php';

 class OrderRepository extends AbstractRepository
{
    
    private const TABLE = "orders";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    public function createOrder($userid,$productsid)
    {  
        foreach($productsid as $productid){
            
            $sql = "INSERT INTO orders (user_id,product_id,created_at) VALUES ('$userid','$productid', NOW())";
            $stmt = $this->connexion->query($sql);
            
       }
        
    }
    
     public function findById($userid)
    {
         $data = null;
        try {                                  
            $query = $this->connexion->prepare('SELECT * FROM products as p INNER JOIN orders as ord ON p.id = ord.product_id WHERE ord.user_id = :id');
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
    
     public function deleteOrder($userid)
    {  
        $sql = "DELETE FROM orders WHERE user_id = '$userid' ";
        $stmt = $this->connexion->query($sql);
      
       }
}