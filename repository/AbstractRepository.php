<?php
abstract class AbstractRepository
{
    
    private const SERVER = "db.3wa.io";
    private const USER = "jocelynretiere";
    private const PASSWORD = "dabe70939c4c64d41ab82bc666ae29d5";
    private const BASE = "jocelynretiere_symphonie";
    
    protected $table;
    protected $connexion;
    protected $query;

    public function __construct(string $table)
    {
        $this->constructConnexion();
        $this->table = $table;
    }
    
    public function fetchAll(){
        $data = null;
        try {
            $resultat = $this->connexion->query('SELECT * FROM '.$this->table);
            if ($resultat) {
                $data = $resultat->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die($e);
        }
        
        return $data;
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