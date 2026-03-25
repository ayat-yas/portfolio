<?php 
// vue/erreur.php
$message = $message ?? 'Une erreur inconnue est survenue.';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" style="text-align: center;">
        <h1>Erreur</h1>
        <p style="color: red; font-size: 1.2em;"><?php echo htmlspecialchars($message); ?></p>
        <p><a href="index.php?page=home" class="btn btn-primary">Retour à l'accueil</a></p>
    </div>
</body>
</html>