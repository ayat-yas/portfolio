<h2> Gestion des propriétaires </h2>

<?php
    // 1. Vérification des droits d'accès
    if(isset($_SESSION['droits']) && $_SESSION['droits'] == "admin"){

        $leProprio = null; 

        // 2. Traitement des actions (suppression et modification)
        if (isset($_GET['action']) && isset($_GET['idproprio'])) {
            $action = $_GET['action'];
            $idproprio = $_GET['idproprio']; 

            switch ($action) {
                case "sup": $unControleur->deleteProprio($idproprio);
                            header("Location: index.php?page=4"); break;
                case "mod": $leProprio = $unControleur->selectWhereProprio($idproprio); break;
            }
        }

        // 3. Inclusion du formulaire d'insertion/modification
        require_once("vue/vue_insert_proprio.php");

        // 4. Traitement de l'insertion
        if (isset($_POST['Valider'])) {
            $unControleur->insertProprio($_POST);
            echo "<br> Insertion réussie du propriétaire.";
            header("Location: index.php?page=4");
        }

        // 5. Traitement de la modification
        if(isset($_POST['Modifier'])){
            $unControleur->updateProprio($_POST);
            header("Location: index.php?page=4");
        }
    } else {
        echo "<p>Vous n'avez pas les droits d'administrateur pour gérer les propriétaires.</p>";
    }

    // 6. Gestion du filtrage et de l'affichage
    if(isset($_POST['Filtrer'])) {
        $filtre = $_POST['filtre'];
        $lesProprietaires = $unControleur->selectLikeProprietaires($filtre);
    } else {
        $lesProprietaires = $unControleur->selectAllProprietaires();
    }

    // 7. Inclusion de la vue d'affichage
    require_once("vue/vue_select_proprio.php");
?>