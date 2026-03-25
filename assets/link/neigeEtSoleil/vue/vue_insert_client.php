<?php 
// vue/vue_insert_client.php
$donnee = $donnee ?? []; // Données du client à modifier
$idName = $idName ?? 'idclient';
$mode = isset($donnee['idclient']) ? 'Modifier' : 'Ajouter';
$action_value = isset($donnee['idclient']) ? 'update' : 'insert';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $mode; ?> un Client</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2><?php echo $mode; ?> un Client</h2>
        
        <?php if (isset($message) && $message): ?>
            <div class="message-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=vue_insert_client">
            <input type="hidden" name="action" value="<?php echo $action_value; ?>">
            
            <?php if (isset($donnee['idclient'])): ?>
                <input type="hidden" name="idclient" value="<?php echo $donnee['idclient']; ?>">
            <?php endif; ?>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($donnee['nom'] ?? ''); ?>" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($donnee['prenom'] ?? ''); ?>" required>
            
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($donnee['email'] ?? ''); ?>" required>

            <label for="mdp">Mot de passe (Laisser vide si inchangé en modification) :</label>
            <input type="password" id="mdp" name="mdp" <?php echo $mode === 'Ajouter' ? 'required' : ''; ?>>
            
            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($donnee['adresse'] ?? ''); ?>" required>

            <label for="telephone">Téléphone :</label>
            <input type="number" id="telephone" name="telephone" value="<?php echo htmlspecialchars($donnee['telephone'] ?? ''); ?>" required>

            <button type="submit" class="btn btn-<?php echo $mode === 'Ajouter' ? 'success' : 'warning'; ?>"><?php echo $mode; ?> le Client</button>
            <a href="index.php?page=gestion_client" class="btn btn-primary">Annuler et Retour à la liste</a>
        </form>
        
    </div>
</body>
</html>