<?php
// modele/config_db.php

class ConnexionDB {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // !!! MODIFIEZ CES PARAMÈTRES AVEC VOS IDENTIFIANTS LOCAUX !!!
        $host = 'localhost';
        $db   = 'n&s_31_jv'; // Nom de la base tel que défini dans votre SQL
        $user = 'root';      
        $pass = '';          
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            // En cas d'erreur de connexion
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new ConnexionDB();
        }
        return self::$instance;
    }

    public function getPDO() {
        return $this->pdo;
    }
}
?>