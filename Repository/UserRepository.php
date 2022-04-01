<?php

require_once './Repository/AbstractRepository.php';

 class UserRepository extends AbstractRepository
{
    
    private const TABLE = "users";
    
    public function __construct(){
        parent::__construct(self::TABLE);
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
    
    
        public function createUser(string $newlastName,string $newfirstName, string $newEmail, string $newPass,string $newAdress,int $wallet):void
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password,adress,wallet,role, created_at) VALUES ('$newfirstName','$newlastName','$newEmail','$newPass','$newAdress','$wallet','client', NOW())";
        $stmt = $this->connexion->query($sql);
       
    }
    
    
    
}