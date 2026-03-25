<?php 
// gestion_gite.php
<h2>Gestion des gîtes</h2>

// Contrôleur pour la gestion des gîtes
$leGite = null;

// Récupération de l'ID du propriétaire connecté
$idProprioConnecte = $_SESSION['user_id'] ?? 0;

// Gestion des actions GET (modifier ou supprimer)
if (isset($_GET['action']) && isset($_GET['idgite'])) {
    $action = $_GET['action'];
    $idgite = $_GET['idgite'];

    switch ($action) {
        case "sup":
            $unControleur->deleteGites($idgite);
            header("location: index.php?page=gestion_gite");
            exit;
        case "mod":
            $leGite = $unControleur->selectWhereGite($idgite);
            break;
    }
}

// Inclusion du formulaire d'insertion/modification
require_once("vue/vue_insert_gite.php");

// Ajout ou modification POST
if (isset($_POST['Ajouter'])) {
    // On force l'ID du proprio connecté pour éviter toute manipulation
    $_POST['idproprio'] = $idProprioConnecte;
    $unControleur->insertGite($_POST);
    header("location: index.php?page=gestion_gite");
    exit;
}

if (isset($_POST['Modifier'])) {
    $_POST['idproprio'] = $idProprioConnecte;
    $unControleur->updateGite($_POST);
    header("location: index.php?page=gestion_gite");
    exit;
}

// Gestion des filtres
$filtre_adresse = $_POST['filtre_adresse'] ?? '';
$filtre_type = $_POST['filtre_type'] ?? '';

// Récupération des gîtes selon le propriétaire et filtres
if (!empty($filtre_adresse) || !empty($filtre_type)) {
    $lesGites = $unControleur->selectLikeGitesByProprio($idProprioConnecte, $filtre_adresse, $filtre_type);
} else {
    $lesGites = $unControleur->selectGitesByProprio($idProprioConnecte);
}

// Affichage de la liste des gîtes
require_once("vue/vue_select_gite.php");
?>
