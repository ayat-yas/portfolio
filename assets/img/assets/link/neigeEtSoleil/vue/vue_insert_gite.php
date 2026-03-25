<?php 
// vue/vue_insert_gite.php
$donnee = $donnee ?? []; // Données du gîte à modifier
$mode = isset($donnee['idgite']) ? 'Modifier' : 'Ajouter';
$action_value = isset($donnee['idgite']) ? 'update' : 'insert';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $mode; ?> un Gîte</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="number"],
        form select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        form .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }
        form .btn {
            margin-top: 15px;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
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
        <h2><?php echo $mode; ?> un Gîte</h2>
        
        <?php if (isset($message) && $message): ?>
            <div class="message-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=vue_insert_gite">
            <input type="hidden" name="action" value="<?php echo $action_value; ?>">
            
            <?php if (isset($donnee['idgite'])): ?>
                <input type="hidden" name="idgite" value="<?php echo $donnee['idgite']; ?>">
            <?php endif; ?>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($donnee['adresse'] ?? ''); ?>" required>

            <label for="surface">Surface (m²) :</label>
            <input type="number" id="surface" name="surface" value="<?php echo htmlspecialchars($donnee['surface'] ?? ''); ?>" required>

            <label for="nbpieces">Nombre de pièces :</label>
            <input type="number" id="nbpieces" name="nbpieces" value="<?php echo htmlspecialchars($donnee['nbpieces'] ?? ''); ?>" required>

            <label for="type_gite">Type de gîte :</label>
            <select id="type_gite" name="type_gite" required>
                <option value="">-- Sélectionner le type --</option>
                <?php
                $types = ['Studio', 'F1', 'F2', 'F3', 'F4'];
                foreach ($types as $type) {
                    $selected = (isset($donnee['type_gite']) && $donnee['type_gite'] === $type) ? 'selected' : '';
                    echo "<option value=\"$type\" $selected>$type</option>";
                }
                ?>
            </select>

            <label>Parking :</label>
            <div class="radio-group">
                <?php 
                    $parking = $donnee['parking'] ?? 0;
                ?>
                <label>
                    <input type="radio" name="parking" value="1" <?php echo $parking == 1 ? 'checked' : ''; ?>>
                    Oui
                </label>
                <label>
                    <input type="radio" name="parking" value="0" <?php echo $parking == 0 ? 'checked' : ''; ?>>
                    Non
                </label>
            </div>

            <label for="loyer">Loyer journalier (€) :</label>
            <input type="number" id="loyer" name="loyer" value="<?php echo htmlspecialchars($donnee['loyer'] ?? ''); ?>" required>

            <?php 
            // Propriétaire connecté
            $idproprio = $_SESSION['user_id']; 
            $nomproprio = $_SESSION['user_nom']; 
            ?>
            <label>Propriétaire :</label>
            <input type="hidden" name="idproprio" value="<?php echo $idproprio; ?>">
            <input type="text" value="<?php echo htmlspecialchars($nomproprio); ?>" disabled>

            <button type="submit" class="btn btn-<?php echo $mode === 'Ajouter' ? 'success' : 'warning'; ?>"><?php echo $mode; ?> le Gîte</button>
            <a href="index.php?page=gestion_gite" class="btn btn-primary">Annuler et Retour à la liste</a>
        </form>
    </div>
</body>
</html>
