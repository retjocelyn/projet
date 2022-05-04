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
    
    public function createProduct($product):bool
    {    
        
        try{
             $query = $this->connexion->prepare('INSERT INTO products
                (name,description,quantity,price,category_id,url_picture,created_at)
                VALUES (:productName,:productDescription,:productQuantity,
                :productPrice,:productCategory,:productImage, NOW())');

            
            if ($query) {
               
                $query->bindValue(':productName',$product->getName());
                $query->bindValue(':productDescription',$product->getDescription());
                $query->bindValue(':productQuantity',$product->getQuantity());
                $query->bindValue(':productPrice',$product->getPrice());
                $query->bindValue(':productCategory',$product->getCategory());
                $query->bindValue(':productImage',$product->getImage());
                
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
    
    
    public function modifyProduct( Product $product) :bool
    {    
       
         
         try{
             $query = $this->connexion->prepare('UPDATE products
                SET name = :name,description = :description,
                quantity = :quantity,price = :price, 
                category_id = :category, url_picture = :image,
                created_at = NOW()
                WHERE id = :id ');
            
            if ($query) {
               
                $query->bindValue(':name',$product->getName());
                $query->bindValue(':description',$product->getDescription());
                $query->bindValue(':quantity',$product->getQuantity());
                $query->bindValue(':price',$product->getPrice());
                $query->bindValue(':category',$product->getCategory());
                $query->bindValue(':image',$product->getImage());
                $query->bindValue(':id',$product->getId());
                
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
        
    
    
    public function deleteProduct($productId) :bool
    {
         
         try{
             $query = $this->connexion->prepare('DELETE FROM products WHERE id = :id');
            
            if ($query) {
               
                $query->bindValue(':id',$productId);
                
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
        
    
    
    public function fetchImage($productId)
    {
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT url_picture FROM products WHERE id = :id');
            if ($query) {
                $query->bindParam(':id', $productId);
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