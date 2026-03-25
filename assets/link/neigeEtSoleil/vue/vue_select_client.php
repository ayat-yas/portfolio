<?php 
// vue/vue_select_client.php
$clients = $donnees; 
$message = $_GET['msg'] ?? ($message ?? ''); 
$table = $table ?? 'client';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="gestion-header">
            <h2>Gestion des Clients</h2>
            <img src="images/client_icone.png" alt="Gestion des Clients" class="gestion-image">
        </div>
        
        <p>
            <a href="index.php?page=home" class="btn btn-primary">Retour à l'accueil</a>
            <a href="index.php?page=vue_insert_client" class="btn btn-success">Ajouter un nouveau Client</a>
        </p>

        <?php if ($message): ?>
            <div class="message-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h3>Liste des Clients (<?php echo count($clients); ?>)</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                    <tr><td colspan="5" style="text-align: center;">Aucun client trouvé.</td></tr>
                <?php endif; ?>
                <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo $client['idclient']; ?></td>
                    <td><?php echo $client['nom'] . ' ' . $client['prenom']; ?></td>
                    <td><?php echo $client['email']; ?></td>
                    <td><?php echo $client['telephone']; ?></td>
                    <td class="table-actions">
                        <a href="index.php?page=vue_insert_client&id=<?php echo $client['idclient']; ?>" class="btn btn-warning">Modifier</a>
                        <form method="POST" style="display:inline;" action="index.php?page=gestion_client">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $client['idclient']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ? Toute réservation associée sera également supprimée.')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>