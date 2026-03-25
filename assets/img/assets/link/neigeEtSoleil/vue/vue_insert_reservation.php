<?php 
// vue/vue_insert_reservation.php
$donnee = $donnee ?? []; 
$idName = $idName ?? 'idreservation';
$clients_list = $clients_list ?? [];
$gites_list = $gites_list ?? [];
$mode = isset($donnee['idreservation']) ? 'Modifier' : 'Ajouter';
$action_value = isset($donnee['idreservation']) ? 'update' : 'insert';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $mode; ?> une Réservation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2><?php echo $mode; ?> une Réservation</h2>
        
        <?php if (isset($message) && $message): ?>
            <div class="message-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=vue_insert_reservation">
            <input type="hidden" name="action" value="<?php echo $action_value; ?>">
            
            <?php if (isset($donnee['idreservation'])): ?>
                <input type="hidden" name="idreservation" value="<?php echo $donnee['idreservation']; ?>">
            <?php endif; ?>

            <label for="idclient">Client :</label>
            <select id="idclient" name="idclient" required>
                <option value="">-- Sélectionner un Client --</option>
                <?php foreach ($clients_list as $client): ?>
                    <?php 
                        $selected = '';
                        if (isset($donnee['idclient']) && $donnee['idclient'] == $client['idclient']) {
                            $selected = 'selected';
                        }
                    ?>
                    <option value="<?php echo $client['idclient']; ?>" <?php echo $selected; ?>>
                        <?php echo $client['nom'] . ' ' . $client['prenom'] . ' (' . $client['email'] . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="idgite">Gîte Réservé :</label>
            <select id="idgite" name="idgite" required>
                <option value="">-- Sélectionner un Gîte --</option>
                <?php foreach ($gites_list as $gite): ?>
                    <?php 
                        $selected = '';
                        if (isset($donnee['idgite']) && $donnee['idgite'] == $gite['idgite']) {
                            $selected = 'selected';
                        }
                    ?>
                    <option value="<?php echo $gite['idgite']; ?>" <?php echo $selected; ?>>
                        <?php echo $gite['adresse'] . ' - Loyer : ' . $gite['loyer'] . '€/jour'; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="datedebut">Date de Début :</label>
            <input type="date" id="datedebut" name="datedebut" value="<?php echo htmlspecialchars($donnee['datedebut'] ?? ''); ?>" required>

            <label for="datefin">Date de Fin :</label>
            <input type="date" id="datefin" name="datefin" value="<?php echo htmlspecialchars($donnee['datefin'] ?? ''); ?>" required>
            
            <label for="prix">Prix Total (€) :</label>
            <input type="number" step="0.01" id="prix" name="prix" value="<?php echo htmlspecialchars($donnee['prix'] ?? ''); ?>" required>
            
            <label for="assurance">Assurance :</label>
            <select id="assurance" name="assurance" required>
                <option value="0" <?php echo (isset($donnee['assurance']) && $donnee['assurance'] == 0) ? 'selected' : ''; ?>>Non</option>
                <option value="1" <?php echo (isset($donnee['assurance']) && $donnee['assurance'] == 1) ? 'selected' : ''; ?>>Oui</option>
            </select>

            <label for="transport">Option Transport :</label>
            <select id="transport" name="transport" required>
                <option value="bus" <?php echo (isset($donnee['transport']) && $donnee['transport'] == 'bus') ? 'selected' : ''; ?>>Bus</option>
                <option value="train" <?php echo (isset($donnee['transport']) && $donnee['transport'] == 'train') ? 'selected' : ''; ?>>Train</option>
                <option value="aucun" <?php echo (isset($donnee['transport']) && $donnee['transport'] == 'aucun') ? 'selected' : ''; ?>>Aucun</option>
            </select>
            
            <button type="submit" class="btn btn-<?php echo $mode === 'Ajouter' ? 'success' : 'warning'; ?>"><?php echo $mode; ?> la Réservation</button>
            <a href="index.php?page=gestion_reservation" class="btn btn-primary">Annuler et Retour à la liste</a>
        </form>
    </div>
</body>
</html>