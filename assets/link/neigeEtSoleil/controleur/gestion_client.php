<h2> Gestion des clients </h2>

<?php 
    // Vérification des droits d'accès est faite dans index.php

    // Initialisation
    $leClient = null;

    // 1. Traitement des actions (suppression et modification)
    if (isset($_GET['action']) && isset($_GET['idclient'])) {
        $action = $_GET['action'];
        $idclient = $_GET['idclient'];

        switch ($action) {
            case "sup": 
                $unControleur->deleteClient($idclient);
                // Redirection après suppression
                header("Location: index.php?page=2");
                break; 
            case "mod": 
                $leClient = $unControleur->selectWhereClient($idclient); 
                break;
        }
    }

    // 2. Inclusion du formulaire d'insertion/modification
    require_once("vue/vue_insert_client.php");

    // 3. Traitement de l'insertion
    if (isset($_POST['Valider'])) {
        $unControleur->insertClient($_POST); 
        // Redirection après insertion
        header("Location: index.php?page=2");
        exit;
    }

    // 4. Traitement de la modification
    if(isset($_POST['Modifier'])){
        $unControleur->updateClient($_POST);

        // Redirection après modification
        header("Location: index.php?page=2");
        exit;
    }
    
    // 5. Gestion du filtrage et de l'affichage
    if(isset($_POST['Filtrer'])) {
        $filtre = $_POST['filtre'];
        $lesClients = $unControleur->selectLikeClients($filtre);
    }else {
        $lesClients = $unControleur->selectAllClients();
    }

    // 6. Affichage de la vue de sélection
    require_once("vue/vue_select_client.php");
?>