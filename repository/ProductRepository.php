<?php

require_once './repository/AbstractRepository.php';

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
    
    public function findById($produit)
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
        $sql = " UPDATE products
            SET name = '$newProductName',description = '$newProductDescription',quantity = '$newProductQuantity',price = '$newProductPrice', category_id = '$newProductCategory', url_picture = '$newProductImage',created_at = NOW()
            WHERE id = '$id' ";
         $stmt = $this->connexion->query($sql);
        
    }
    
    public function deleteProduct($id)
    {
         $sql = "DELETE FROM products WHERE id = '$id' ";
         $stmt = $this->connexion->query($sql);
    }
    
    public function fetchImage($id)
    {
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT url_picture FROM products WHERE id = :id');
            if ($query) {
                $query->bindParam(':id', $id);
                $query->execute();
                
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
     
    public function fetchQuery($product): array
    {
        $request = '%'.$product.'%';
        $data = [];
        try {
            $query = $this->connexion->prepare("SELECT * FROM products WHERE name LIKE :name LIMIT 3");
            if ($query) {
                $query->bindParam(':name', $request);
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
        
        return $data;
    }
    
}