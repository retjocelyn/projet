<?php

require_once './repository/AbstractRepository.php';

 class UserRepository extends AbstractRepository
{
    
    private const TABLE = "users";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    public function fetchAllCostumers()
    {
        $data = null;
        
        try {
            $query = $this->connexion->prepare('SELECT * FROM users WHERE role = "client" ORDER BY last_name');
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
    
    
    public function createUser($user)
    {
        
        try {
            $query = $this->connexion->prepare('INSERT INTO users (first_name, last_name, email, password,adress,wallet,role,created_at) 
            VALUES (:newfirstName,:newlastName,:email,:newPass,:adress,:wallet,:role, NOW() )');
            if ($query) {
               
                $query->bindValue(':newlastName',$user->getlastName());
                $query->bindValue(':newfirstName',$user->getFirstName());
                $query->bindValue(':email',$user->getEmail());
                $query->bindValue(':newPass',$user->getPassword());
                $query->bindValue(':adress',$user->getAdresse());
                $query->bindValue(':wallet',$user->getWallet());
                $query->bindValue(':role', $user->getRole());
                
                 return $query->execute();
            }
        } catch (Exception $e) {
           return false;
        }
    }
       
    
    public function modifyUser(User $user):bool
    {
        try{
             $query = $this->connexion->prepare('UPDATE users
                SET first_name = :newfirstName,last_name = :newlastName,
                email = :newEmail, adress = :newAdress,password = :newPass
                WHERE id = :id');
            
            if ($query) {
               
                $query->bindValue(':newlastName',$user->getlastName());
                $query->bindValue(':newfirstName',$user->getFirstName());
                $query->bindValue(':newEmail',$user->getEmail());
                $query->bindValue(':newPass',$user->getPassword());
                $query->bindValue(':newAdress',$user->getAdresse());
                $query->bindValue(':id',$user->getId());
               
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
       
       
    public function deleteUser(?int $userId):bool
    {
        
      try{
             $query = $this->connexion->prepare('DELETE from users WHERE id = :id');
            
            if ($query) {
                $query->bindValue(':id',$userId);
               
                return $query->execute();
            }
        }catch (Exception $e) {
            return false;
        }
    }
         
    
    public function addMoney(int $userId, float $newAmount)
    {
     
        try {
            $query = $this->connexion->prepare('UPDATE users SET wallet = :amount WHERE id = :userId');
            
            if ($query) {
                
                $query->bindParam(':userId',$userId );
                $query->bindParam(':amount', $newAmount); 
                return $query->execute();
             
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
}
    
    
