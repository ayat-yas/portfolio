<?php
// modele/modele.class.php

require_once 'config_db.php'; 

class Modele {
    protected $pdo;

    public function __construct() {
        $this->pdo = ConnexionDB::getInstance()->getPDO();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // AUTHENTIFICATION
    public function getUtilisateurByEmail($email, $table) {
        $sql = "SELECT * FROM $table WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // CRUD GÉNÉRIQUE 
    public function selectAll($table) {
        $sql = "SELECT * FROM $table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function selectAllGites(){
    $sql = "SELECT * FROM gite ORDER BY adresse ASC";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function selectWhereId($table, $idName, $idValue) {
        $sql = "SELECT * FROM $table WHERE $idName = :idValue";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idValue' => $idValue]);
        return $stmt->fetch();
    }
    public function delete($table, $idName, $idValue) {
        $sql = "DELETE FROM $table WHERE $idName = :idValue";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['idValue' => $idValue]);
    }
    
    // --- METHODES SPECIFIQUES CLIENT ---
    public function insertClient($data) {
        $sql = "INSERT INTO client (nom, prenom, adresse, email, mdp, telephone) 
                VALUES (:nom, :prenom, :adresse, :email, :mdp, :telephone)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    public function updateClient($data) {
        $sql = "UPDATE client SET nom = :nom, prenom = :prenom, adresse = :adresse, 
                email = :email, telephone = :telephone";
        $params = [
            'nom' => $data['nom'], 'prenom' => $data['prenom'], 'adresse' => $data['adresse'], 
            'email' => $data['email'], 'telephone' => $data['telephone'], 'idclient' => $data['idclient']
        ];
        
        if (isset($data['mdp'])) { 
            $sql .= ", mdp = :mdp";
            $params['mdp'] = $data['mdp'];
        }

        $sql .= " WHERE idclient = :idclient";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    // --- METHODES SPECIFIQUES GITE ---
    public function insertGite($data) {
    $sql = "INSERT INTO gite (adresse, surface, nbpieces, loyer, idproprio, type_gite, parking) 
            VALUES (:adresse, :surface, :nbpieces, :loyer, :idproprio, :type_gite, :parking)";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        'adresse' => $data['adresse'], 
        'surface' => $data['surface'], 
        'nbpieces' => $data['nbpieces'], 
        'loyer' => $data['loyer'], 
        'idproprio' => $data['idproprio'],
        'type_gite' => $data['type_gite'],
        'parking' => $data['parking']
    ]);
}

    public function updateGite($data) {
    $sql = "UPDATE gite SET adresse = :adresse, surface = :surface, nbpieces = :nbpieces, 
            loyer = :loyer, idproprio = :idproprio, type_gite = :type_gite, parking = :parking 
            WHERE idgite = :idgite";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        'adresse' => $data['adresse'], 
        'surface' => $data['surface'], 
        'nbpieces' => $data['nbpieces'], 
        'loyer' => $data['loyer'], 
        'idproprio' => $data['idproprio'],
        'type_gite' => $data['type_gite'],
        'parking' => $data['parking'],
        'idgite' => $data['idgite']
    ]);
}
// Sélectionne tous les gîtes d'un proprio
public function selectGitesByProprio($idproprio) {
    $sql = "SELECT * FROM gite WHERE idproprio = :idproprio ORDER BY idgite ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['idproprio' => $idproprio]);
    return $stmt->fetchAll();
}

// Sélectionne les gîtes filtrés d'un proprio par adresse ou type
public function selectLikeGitesByProprio($idproprio, $filtre_adresse = '', $filtre_type = '') {
    $sql = "SELECT * FROM gite WHERE idproprio = :idproprio";
    $params = ['idproprio' => $idproprio];

    if (!empty($filtre_adresse)) {
        $sql .= " AND adresse LIKE :adresse";
        $params['adresse'] = '%' . $filtre_adresse . '%';
    }
    if (!empty($filtre_type)) {
        $sql .= " AND type_gite LIKE :type_gite";
        $params['type_gite'] = '%' . $filtre_type . '%';
    }

    $sql .= " ORDER BY idgite ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

    

    // --- RECHERCHE / FILTRE GITES ---
// Sélection des gîtes avec filtres sur adresse et type de gîte
public function selectLikeGites($filtre_adresse = '', $filtre_type = '') {
    $sql = "SELECT * FROM gite WHERE 1=1";
    $params = [];

    if (!empty($filtre_adresse)) {
        $sql .= " AND adresse LIKE :adresse";
        $params['adresse'] = '%' . $filtre_adresse . '%';
    }

    if (!empty($filtre_type)) {
        $sql .= " AND type_gite LIKE :type_gite";
        $params['type_gite'] = '%' . $filtre_type . '%';
    }

    $sql .= " ORDER BY idgite ASC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}



    // --- METHODES SPECIFIQUES PROPRIO ---
    public function insertProprio($data) {
        $sql = "INSERT INTO proprio (nom, prenom, adresse, email, mdp, telephone, statut) 
                VALUES (:nom, :prenom, :adresse, :email, :mdp, :telephone, :statut)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    public function updateProprio($data) {
        $sql = "UPDATE proprio SET nom = :nom, prenom = :prenom, adresse = :adresse, 
                email = :email, telephone = :telephone, statut = :statut";
        $params = [
            'nom' => $data['nom'], 'prenom' => $data['prenom'], 'adresse' => $data['adresse'], 
            'email' => $data['email'], 'telephone' => $data['telephone'], 'statut' => $data['statut'], 'idproprio' => $data['idproprio']
        ];
        
        if (isset($data['mdp'])) { 
            $sql .= ", mdp = :mdp";
            $params['mdp'] = $data['mdp'];
        }

        $sql .= " WHERE idproprio = :idproprio";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    // --- METHODES SPECIFIQUES RESERVATION (CORRIGEES) ---
    public function insertReservation($data) {
        // Aligné sur le nouveau SQL
        $sql = "INSERT INTO reservation (datedebut, datefin, prix, idclient, idgite, statut_r) 
                VALUES (:datedebut, :datefin, :prix, :idclient, :idgite, :statut_r)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    public function updateReservation($data) {
        // Aligné sur le nouveau SQL
        $sql = "UPDATE reservation SET datedebut = :datedebut, datefin = :datefin, 
                prix = :prix, idclient = :idclient, idgite = :idgite, statut_r = :statut_r, rapport = :rapport
                WHERE idreservation = :idreservation";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    // Requête principale de sélection des réservations
    public function selectAllReservations($filters = []) {
        $sql = "SELECT r.*, c.nom as client_nom, c.prenom as client_prenom, g.adresse as gite_adresse 
                FROM reservation r
                INNER JOIN client c ON r.idclient = c.idclient
                INNER JOIN gite g ON r.idgite = g.idgite
                WHERE 1=1";
        $params = [];

        if (!empty($filters['idclient'])) {
            $sql .= " AND r.idclient = :idclient";
            $params['idclient'] = $filters['idclient'];
        }
        if (!empty($filters['idgite'])) {
            $sql .= " AND r.idgite = :idgite";
            $params['idgite'] = $filters['idgite'];
        }
        
        $sql .= " ORDER BY r.datedebut DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>