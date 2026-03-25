<h2> Gestion des réservations </h2>

<?php
    // 1. Vérification des droits d'accès
    if(isset($_SESSION['droits']) && $_SESSION['droits'] == "admin"){

        $laReservation = null; 
        $lesClients = $unControleur->selectAllClients();
        $lesGites = $unControleur->selectAllGites();

        // 2. Traitement des actions (suppression et modification)
        if (isset($_GET['action']) && isset($_GET['idresa'])) {
            $action = $_GET['action'];
            $idresa = $_GET['idresa']; 

            switch ($action) {
                case "sup": $unControleur->deleteReservation($idresa); 
                            header("Location: index.php?page=5"); break;
                case "mod": $laReservation = $unControleur->selectWhereReservation($idresa); 
                            break;
            }
        }

        // 3. Inclusion du formulaire d'insertion/modification
        require_once("vue/vue_insert_reservation.php");

        // 4. Traitement de l'insertion
        if (isset($_POST['Valider'])) {
            $unControleur->insertReservation($_POST);
            echo "<br> Insertion réussie de la réservation.";
            header("Location: index.php?page=5");
        }

        // 5. Traitement de la modification
        if(isset($_POST['Modifier'])){
            $unControleur->updateReservation($_POST);
            header("Location: index.php?page=5"); 
        }
    } else {
        echo "<p>Vous n'avez pas les droits d'administrateur pour gérer les réservations.</p>";
    }

// ... (code avant la fin)

    // 6. Gestion du filtrage et de l'affichage
    if(isset($_POST['Filtrer'])) {
        $filtre = $_POST['filtre'];
        $lesReservations = $unControleur->selectLikeReservations($filtre);
    }else {
        $lesReservations = $unControleur->selectAllReservations();
    }
    
    // CORRECTION: Ajout de l'inclusion de la vue de sélection
    require_once("vue/vue_select_reservation.php");
?>