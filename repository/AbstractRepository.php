<?php
abstract class AbstractRepository
{
    
    private const SERVER = "db.3wa.io";
    private const USER = "jocelynretiere";
    private const PASSWORD = "dabe70939c4c64d41ab82bc666ae29d5";
    private const BASE = "jocelynretiere_symphonie";
    
    protected $connexion;
    protected $query;

    public function __construct()
    {
        $this->constructConnexion();
      
    }
    
  
    private function constructConnexion(){
        
        try {
            
            $this->connexion = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::BASE, self::USER, self::PASSWORD);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $this->connexion->exec("SET CHARACTER SET utf8");
    }
}