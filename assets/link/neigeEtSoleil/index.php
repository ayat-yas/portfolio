<?php
// index.php
// Point d'entrée unique de l'application MVC

// Inclusion du contrôleur principal
require_once 'controleur/controleur.class.php';

// Création de l'instance du contrôleur
$controleur = new Controleur();

// Gestion de la requête
$controleur->gererRequete();
?>