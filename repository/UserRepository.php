<?php

require_once './repository/AbstractRepository.php';

 class UserRepository extends AbstractRepository
{
    
    private const TABLE = "users";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    public function fetchAll()
    {
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM users');
            if ($query) {
                $query->execute();
                
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    public function fetchLogin($email)
    {
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM users WHERE email = :email');
            if ($query) {
                $query->bindParam(':email', $email);
                $query->execute();
                
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    public function findById($userId)
    {
        $data = null;
        try {
            $query = $this->connexion->prepare('SELECT * FROM users WHERE id = :userId');
            if ($query) {
                $query->bindParam(':userId',$userId);
                $query->execute();
                
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
    }
    
    
    public function createUser(string $newlastName,string $newfirstName, string $newEmail, string $newPass,string $newAdress,int $wallet):void
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password,adress,wallet,role, created_at) VALUES ('$newfirstName','$newlastName','$newEmail','$newPass','$newAdress','$wallet','client', NOW())";
        $stmt = $this->connexion->query($sql);
       
    }
    
     public function modifyUser($userId,$newlastName,$newfirstName,$newEmail,$newAdress,$newPass)
     {
          $sql = " UPDATE users
            SET first_name = '$newfirstName',last_name = '$newlastName',email = '$newEmail',adress = '$newAdress',password = '$newPass'
            WHERE id = '$userId' ";
         $stmt = $this->connexion->query($sql);
        
     }
     
    public function deleteUser($id)
    {
        $sql = "DELETE FROM `users` WHERE id = '$id'";
         $stmt = $this->connexion->query($sql);
    }
    
    
    
    
}