<?php 
// vue/home.php
$statut = $_SESSION['user_statut'] ?? 'visiteur';
$nom = $_SESSION['user_nom'] ?? 'Visiteur';
$isAdminOrProprio = in_array($statut, ['admin', 'privé', 'public']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - NEIGEETSOLEIL</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
            text-align: center;
        }
        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .menu-item img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenue, <?php echo $nom; ?> !</h2>
        <p style="text-align: center;">Vous êtes connecté en tant que : <strong><?php echo ucfirst($statut); ?></strong></p>

        <p style="text-align: center; margin-bottom: 40px;"><a href="index.php?page=deconnexion" class="btn btn-danger">Déconnexion</a></p>

        <h3>Actions Disponibles</h3>

        <div class="menu-grid">
            
            <a href="index.php?page=gestion_gite" class="menu-item btn-primary">
                
                Gérer les Gîtes
            </a>

            <a href="index.php?page=gestion_reservation" class="menu-item btn-primary">
                
                Gérer les Réservations
            </a>

            <?php if ($isAdminOrProprio): ?>
            <a href="index.php?page=gestion_client" class="menu-item btn-success">
                

[Image of a people icon]

                Gérer les Clients
            </a>

            <a href="index.php?page=gestion_proprio" class="menu-item btn-success">
                

[Image of a key icon]

                Gérer les Propriétaires
            </a>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>