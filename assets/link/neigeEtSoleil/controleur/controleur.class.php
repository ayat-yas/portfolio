<?php
// controleur/controleur.class.php

require_once 'modele/modele.class.php';

class Controleur {
    protected $modele;

    public function __construct() {
        $this->modele = new Modele();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function gererRequete() {
        $page = $_GET['page'] ?? 'connexion';

        if (!isset($_SESSION['user_id']) && $page !== 'connexion') {
            $page = 'connexion';
        }
        
        if ($page === 'deconnexion') {
            session_destroy();
            header('Location: index.php?page=connexion');
            exit;
        }

        switch ($page) {
            case 'connexion':
                $this->gererConnexion();
                break;
            case 'home':
                $this->gererHome();
                break;
            
            // Pages de gestion RESTREINTES aux Proprio/Admin
            case 'gestion_client':
            case 'gestion_proprio':
                $this->verifierDroitsProprio();
                $this->gererCrud($page);
                break;
                
            // Pages ACCESSIBLES aux Utilisateurs CONNECTÉS (Client et Proprio)
            case 'gestion_gite': // Correction: Accessible aux clients pour consultation
            case 'gestion_reservation':
                $this->verifierDroitsConnecte();
                $this->gererCrud($page);
                break;

            // Vues d'insertion/modification pour chaque gestion
            case 'vue_insert_client':
            case 'vue_insert_gite':
            case 'vue_insert_proprio':
            case 'vue_insert_reservation':
                // La logique des droits est gérée à l'intérieur de gererFormulaire
                $this->gererFormulaire($page);
                break;
            
            default:
                $this->afficherVue('erreur', ['message' => 'Page non trouvée.']);
                break;
        }
    }

    protected function afficherVue($nomVue, $donnees = []) {
        extract($donnees); 
        $cheminVue = 'vue/' . $nomVue . '.php';
        if (file_exists($cheminVue)) {
            require $cheminVue;
        } else {
            $message = "La vue '$nomVue' est introuvable.";
            require 'vue/erreur.php'; 
        }
    }

    // --- LOGIQUE DE CONNEXION (Comparaison en clair) ---
    private function gererConnexion() {
        $erreur = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $mdp = $_POST['mdp'] ?? '';
            $type_user = $_POST['type_user'] ?? '';

            if ($type_user === 'client' || $type_user === 'proprio') {
                $table = $type_user;
                $user = $this->modele->getUtilisateurByEmail($email, $table); 

                if ($user && $mdp === $user['mdp']) {
                    $_SESSION['user_id'] = $user['id' . $table];
                    $_SESSION['user_nom'] = $user['prenom'] . ' ' . $user['nom'];
                    $_SESSION['user_statut'] = $type_user === 'proprio' ? ($user['statut'] ?? 'proprio') : 'client'; 
                    
                    header('Location: index.php?page=home');
                    exit;
                } else {
                    $erreur = 'Identifiants ou type d\'utilisateur incorrects.';
                }
            } else {
                $erreur = 'Sélectionnez un type d\'utilisateur.';
            }
        }
        $this->afficherVue('vue_connexion', ['erreur' => $erreur]);
    }
    
    private function gererHome() {
        $this->afficherVue('home');
    }

    // --- GESTION DES CRUD (SELECT et DELETE) ---
    private function gererCrud($page) {
        $table = str_replace('gestion_', '', $page); 
        $idName = 'id' . $table;
        $message = $_GET['msg'] ?? '';
        
        // GESTION DES ACTIONS DELETE
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
            // Seuls les propriétaires peuvent supprimer
            $this->verifierDroitsProprio(); 
            if ($this->modele->delete($table, $idName, $_POST['id'])) {
                $message = ucfirst($table) . ' supprimé avec succès.';
            } else {
                $message = "Erreur lors de la suppression du " . $table . ".";
            }
        }

        if ($table === 'reservation') {
            $this->gererReservations($message);
        } else {
            // Pour gestion_gite et autres, on affiche
            $donnees = $this->modele->selectAll($table);
            $this->afficherVue('vue_select_' . $table, ['donnees' => $donnees, 'message' => $message, 'table' => $table]);
        }
    }

    private function gererReservations($message = '') {
        $filters = [
            'idclient' => $_GET['filter_client'] ?? null,
            'idgite' => $_GET['filter_gite'] ?? null,
        ];
        
        $peut_modifier = $_SESSION['user_statut'] !== 'client';

        // Si l'utilisateur est un client, il ne voit que ses propres réservations
        if ($_SESSION['user_statut'] === 'client') {
            $filters['idclient'] = $_SESSION['user_id'];
        }

        $donnees = $this->modele->selectAllReservations($filters);
        
        // Les listes filtres et le bouton d'ajout de réservation ne sont disponibles que pour les non-clients
        $clients_list = [];
        $gites_list = [];

        if ($peut_modifier) {
            $clients_list = $this->modele->selectAll('client');
            $gites_list = $this->modele->selectAll('gite');
        }

        $this->afficherVue('vue_select_reservation', [
            'donnees' => $donnees, 
            'message' => $message, 
            'filters' => $filters, 
            'clients_list' => $clients_list, 
            'gites_list' => $gites_list,
            'peut_modifier' => $peut_modifier
        ]);
    }
    
    // --- GESTION DES FORMULAIRES ---
    private function gererFormulaire($page) {
        $table = str_replace('vue_insert_', '', $page); 
        $idName = 'id' . $table;
        $idValue = $_GET['id'] ?? null;
        $message = '';
        $donnee_a_modifier = [];

        // 1. GESTION DES DROITS POUR L'ACCÈS AU FORMULAIRE
        // Seule l'insertion d'une réservation par un client est permise sans droits de propriétaire
        $est_insert_reservation_client = ($table === 'reservation' && $idValue === null && $_SESSION['user_statut'] === 'client');
        
        if (!$est_insert_reservation_client) {
             $this->verifierDroitsProprio();
        }

        // 2. TRAITEMENT POST (INSERT/UPDATE)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $data = $_POST;
            unset($data['action']);
            // Vérifications spécifiques pour le gite
if ($table === 'gite') {
    $surface = floatval($data['surface'] ?? 0);
    $loyer   = floatval($data['loyer'] ?? 0);

    $erreurs = [];

    if ($surface <= 0) {
        $erreurs[] = "La surface doit être supérieure à 0 m².";
    }

    if ($loyer < 500 || $loyer > 5000) {
        $erreurs[] = "Le loyer doit être compris entre 500 € et 5000 €.";
    }

    if (!empty($erreurs)) {
        $message = implode('<br>', $erreurs);
        $donnee_a_modifier = $data; // pour réafficher les valeurs dans le formulaire
        $proprietaires = $this->modele->selectAll('proprio'); // nécessaire pour le select
        $this->afficherVue($page, [
            'donnee' => $donnee_a_modifier,
            'message' => $message,
            'idName' => $idName,
            'proprietaires' => $proprietaires
        ]);
        exit;
    }
}


            try {
                // Gestion du MDP en clair
                if ($table === 'client' || $table === 'proprio') {
                    if (isset($data['mdp']) && empty($data['mdp'])) {
                        unset($data['mdp']);
                    }
                }

                if ($_POST['action'] === 'insert') {
                    // Pour une réservation, si c'est un client qui insère, on force l'ID client
                    if ($table === 'reservation' && $_SESSION['user_statut'] === 'client') {
                         $data['idclient'] = $_SESSION['user_id'];
                    }
                    // Pour une réservation, si la statut_r n'est pas définie (cas client), on la met à 'en cours'
                    if ($table === 'reservation' && !isset($data['statut_r'])) {
                         $data['statut_r'] = 'en cours';
                    }

                    $method = 'insert' . ucfirst($table);
                    if (method_exists($this->modele, $method) && $this->modele->$method($data)) {
                        $message = ucfirst($table) . " ajouté avec succès.";
                    } else {
                        throw new Exception("Erreur lors de l'insertion.");
                    }
                } elseif ($_POST['action'] === 'update' && isset($data[$idName])) {
                    // La modification n'est permise que pour les propriétaires/admin
                    $this->verifierDroitsProprio();
                    
                    $method = 'update' . ucfirst($table);
                    if (method_exists($this->modele, $method) && $this->modele->$method($data)) {
                        $message = ucfirst($table) . " modifié avec succès.";
                    } else {
                        throw new Exception("Erreur lors de la modification.");
                    }
                }
                
                header('Location: index.php?page=gestion_' . $table . '&msg=' . urlencode($message));
                exit;

            } catch (Exception $e) {
                $message = "Erreur : " . $e->getMessage();
            }
        }
        
        // 3. RECUPERATION DES DONNEES POUR MODIFICATION (GET)
        if ($idValue) {
            $donnee_a_modifier = $this->modele->selectWhereId($table, $idName, $idValue);
            if (!$donnee_a_modifier) {
                $message = "ID non trouvé.";
            }
        }
        
        // Récupération des listes pour les clés étrangères
        $proprietaires = [];
        $clients_list = [];
        $gites_list = [];
        
        if ($table === 'gite') {
             $proprietaires = $this->modele->selectAll('proprio');
        } elseif ($table === 'reservation') {
             $clients_list = $this->modele->selectAll('client');
             $gites_list = $this->modele->selectAll('gite');
        }

        $this->afficherVue($page, [
            'donnee' => $donnee_a_modifier, 
            'message' => $message, 
            'idName' => $idName,
            'proprietaires' => $proprietaires,
            'clients_list' => $clients_list, 
            'gites_list' => $gites_list      
        ]);
    }

    // --- DROITS ---
    private function verifierDroitsProprio() {
        $statut = $_SESSION['user_statut'] ?? 'visiteur';
        // Seuls admin/privé/public sont propriétaires
        if (!in_array($statut, ['admin', 'privé', 'public'])) {
            header('Location: index.php?page=home');
            exit;
        }
    }
    
    private function verifierDroitsConnecte() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
    }
}
?>