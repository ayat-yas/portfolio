<?php 
// vue/vue_select_gite.php

$gites = $donnees; 
$message = $_GET['msg'] ?? ($message ?? ''); 
$filtre_adresse = $_POST['filtre_adresse'] ?? '';
$filtre_type = $_POST['filtre_type'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Gîtes</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Styles pour la barre de recherche */
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .search-form input[type="text"] {
            flex: 1;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .search-form button {
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .table-actions a, .table-actions button {
            margin-right: 5px;
        }
        .message-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="gestion-header">
            <h2>Gestion des Gîtes</h2>
            <img src="images/gite_house.png" alt="Gestion des Gîtes" class="gestion-image">
        </div>
        
        <p>
            <a href="index.php?page=home" class="btn btn-primary">Retour à l'accueil</a>
            <a href="index.php?page=vue_insert_gite" class="btn btn-success">Ajouter un Gîte</a>
        </p>

        <?php if ($message): ?>
            <div class="message-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Formulaire de recherche séparé -->
        <form method="POST" action="" class="search-form">
            <input type="text" name="filtre_adresse" placeholder="Rechercher par adresse" 
                   value="<?php echo htmlspecialchars($filtre_adresse); ?>">
            <input type="text" name="filtre_type" placeholder="Rechercher par type de gîte" 
                   value="<?php echo htmlspecialchars($filtre_type); ?>">
            <button type="submit" name="Filtrer" class="btn btn-primary">Filtrer</button>
        </form>

        <h3>Liste des Gîtes (<?php echo count($gites); ?>)</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Adresse</th>
                    <th>Type de gîte</th>
                    <th>Surface (m²)</th>
                    <th>Pièces</th>
                    <th>Loyer (€)</th>
                    <th>Parking</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($gites)): ?>
                    <?php foreach ($gites as $gite): ?>
                    <tr>
                        <td><?php echo $gite['idgite']; ?></td>
                        <td><?php echo htmlspecialchars($gite['adresse']); ?></td>
                        <td><?php echo htmlspecialchars($gite['type_gite'] ?? ''); ?></td>
                        <td><?php echo $gite['surface']; ?></td>
                        <td><?php echo $gite['nbpieces']; ?></td>
                        <td><?php echo $gite['loyer']; ?></td>
                        <td><?php echo isset($gite['parking']) ? ($gite['parking'] ? 'Oui' : 'Non') : ''; ?></td>
                        <td class="table-actions">
                            <a href="index.php?page=vue_insert_gite&id=<?php echo $gite['idgite']; ?>" class="btn btn-warning">Modifier</a>
                            <form method="POST" style="display:inline;" action="index.php?page=gestion_gite">
                                <input type="hidden" name="action" value="sup">
                                <input type="hidden" name="idgite" value="<?php echo $gite['idgite']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce gîte ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Aucun gîte trouvé pour votre compte.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

