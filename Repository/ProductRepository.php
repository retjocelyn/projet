<?php

require_once './Repository/AbstractRepository.php';

 class ProductRepository extends AbstractRepository
{
    
    private const TABLE = "products";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    public function findAll()
    {
         $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM products ');
            if ($query) {
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    public function findByCategory($category)
    {
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM products WHERE category_id = :id');
            if ($query) {
                $query->bindParam(':id', $category);
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    
    public function findByID($produit)
    {
         $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM products WHERE id = :id');
            if ($query) {
                $query->bindParam(':id', $produit);
                $query->execute();
                
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    public function createProduct($newProductCategory,$newProductName,$newProductDescription,$newProductPrice,$newProductQuantity,$newProductImage)
    {    
        $sql = "INSERT INTO products (name,description,quantity,price,category_id,url_picture,created_at) VALUES ('$newProductName','$newProductDescription','$newProductQuantity','$newProductPrice','$newProductCategory','$newProductImage', NOW())";
        $stmt = $this->connexion->query($sql);
    }
    
    public function modifyProduct($id,$newProductCategory,$newProductName,$newProductDescription,$newProductPrice,$newProductQuantity,$newProductImage)
    {    
        
        $sql = "UPDATE products (name,description,quantity,price,category_id,url_picture,created_at) VALUES ('$newProductName','$newProductDescription','$newProductQuantity','$newProductPrice','$newProductCategory','$newProductImage', NOW()) WHERE id = $id";
        $stmt = $this->connexion->query($sql);
    }
    
}