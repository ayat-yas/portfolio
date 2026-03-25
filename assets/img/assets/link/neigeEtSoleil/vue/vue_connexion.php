<?php 
// vue/vue_connexion.php
$erreur = $erreur ?? ''; // Assurez-vous que $erreur existe
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - NEIGEETSOLEIL</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>NEIGE ET SOLEIL</h1>
        <h2>Connexion</h2>
        

        <?php if ($erreur): ?>
            <p style="color: red; text-align: center; font-weight: bold;"><?php echo $erreur; ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?page=connexion">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>

            <label for="type_user">Je me connecte en tant que :</label>
            <select id="type_user" name="type_user" required>
                <option value="proprio">Propriétaire/Admin</option>
                <option value="client">Client</option>
            </select>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>