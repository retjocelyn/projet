<?php

require_once './repository/AbstractRepository.php';

 class BasketRepository extends AbstractRepository
{
    
    private const TABLE = "panier";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
   
    public function addArticleToBasket($userid,$productid): void
    {
        $sql = "INSERT INTO `panier`( `user_id`, `product_id`, `created_at`) VALUES ('$userid','$productid',NOW())";
        
        $stmt = $this->connexion->query($sql);
       
    }
    
    public function findById($userid)
    {
         $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM products as p INNER JOIN panier as pa ON p.id = pa.product_id WHERE pa.user_id = :id');
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
    
    public function deleteArticleFromBasket($productid)
    {
        $sql = "DELETE FROM `panier` WHERE product_id = '$productid' ";
        $stmt = $this->connexion->query($sql);
    }
    
     public function deleteBasket($userid)
    {
        $sql = "DELETE FROM `panier` WHERE user_id = '$userid'";
        $stmt = $this->connexion->query($sql);
    }
    
}