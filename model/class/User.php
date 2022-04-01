<?php

class User {

    
    private int $id;
    
    private string $lastName;
    
    private string $firstName;
    
    private string $email;
    
    private string $password;
    
    private string $role;
    
    private string $adresse;
    
    private string $wallet;
    
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id 
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
    
    /**
     * @param string $name 
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    
    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    
    /**
     * @param string $firstName 
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @param string $email 
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    
    /**
     * @param string $password 
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }
    
    /**
     * @param string $role 
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
    
     /**
     * @return string adresse
     */
     public function getAdresse(): string
    {
        return $this->adresse;
    }
    
    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }
    
    
     /**
     * @return int $wallet
     */
      public function getWallet(): int
    {
        return $this->wallet;
    }
    
    /**
     * @param int $wallet
     */
    public function setWallet(string $wallet): void
    {
        $this->wallet = $wallet;
    }
    
    
    
}