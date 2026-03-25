<?php 
// vue/vue_select_proprio.php
$proprietaires = $donnees; 
$message = $_GET['msg'] ?? ($message ?? ''); 
$table = $table ?? 'proprio';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Propriétaires</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="gestion-header">
            <h2>Gestion des Propriétaires</h2>
            <img src="images/proprio_user.png" alt="Gestion des Propriétaires" class="gestion-image">
        </div>
        
        <p>
            <a href="index.php?page=home" class="btn btn-primary">Retour à l'accueil</a>
            <a href="index.php?page=vue_insert_proprio" class="btn btn-success">Ajouter un Propriétaire</a>
        </p>

        <?php if ($message): ?>
            <div class="message-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h3>Liste des Propriétaires (<?php echo count($proprietaires); ?>)</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proprietaires as $proprio): ?>
                <tr>
                    <td><?php echo $proprio['idproprio']; ?></td>
                    <td><?php echo $proprio['nom'] . ' ' . $proprio['prenom']; ?></td>
                    <td><?php echo $proprio['email']; ?></td>
                    <td><span style="font-weight: bold; color: <?php echo ($proprio['statut'] == 'admin' ? 'red' : ($proprio['statut'] == 'public' ? 'green' : 'blue')); ?>;"><?php echo ucfirst($proprio['statut']); ?></span></td>
                    <td><?php echo $proprio['telephone']; ?></td>
                    <td class="table-actions">
                        <a href="index.php?page=vue_insert_proprio&id=<?php echo $proprio['idproprio']; ?>" class="btn btn-warning">Modifier</a>
                        
                        <form method="POST" style="display:inline;" action="index.php?page=gestion_proprio">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $proprio['idproprio']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('ATTENTION : Supprimer un propriétaire supprime aussi ses gîtes. Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>