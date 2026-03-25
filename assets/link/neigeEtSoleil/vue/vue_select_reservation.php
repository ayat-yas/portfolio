<?php 
// vue/vue_select_reservation.php
$reservations = $donnees; 
$message = $message ?? ''; 
$table = $table ?? 'reservation';
$filters = $filters ?? ['idclient' => null, 'idgite' => null];
$clients_list = $clients_list ?? [];
$gites_list = $gites_list ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réservations</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="gestion-header">
            <h2>Gestion des Réservations</h2>
            <img src="images/reservation_calendar.png" alt="Gestion des Réservations" class="gestion-image">
        </div>
        
        <p>
            <a href="index.php?page=home" class="btn btn-primary">Retour à l'accueil</a>
            <a href="index.php?page=vue_insert_reservation" class="btn btn-success">Ajouter une Réservation</a>
        </p>

        <?php if ($message): ?>
            <div class="message-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h3>Filtrer les Réservations</h3>
        <form method="GET" action="index.php" style="display: flex; gap: 15px; border: 1px solid #007bff; padding: 15px; align-items: flex-end;">
            <input type="hidden" name="page" value="gestion_reservation">

            <div style="flex-grow: 1;">
                <label for="filter_client">Filtrer par Client :</label>
                <select id="filter_client" name="filter_client" style="width: 100%;">
                    <option value="">Tous les Clients</option>
                    <?php foreach ($clients_list as $client): ?>
                        <option value="<?php echo $client['idclient']; ?>" 
                            <?php echo ($filters['idclient'] == $client['idclient'] ? 'selected' : ''); ?>>
                            <?php echo $client['nom'] . ' ' . $client['prenom'] . ' (' . $client['idclient'] . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="flex-grow: 1;">
                <label for="filter_gite">Filtrer par Gîte :</label>
                <select id="filter_gite" name="filter_gite" style="width: 100%;">
                    <option value="">Tous les Gîtes</option>
                    <?php foreach ($gites_list as $gite): ?>
                        <option value="<?php echo $gite['idgite']; ?>" 
                            <?php echo ($filters['idgite'] == $gite['idgite'] ? 'selected' : ''); ?>>
                            <?php echo $gite['adresse'] . ' (ID: ' . $gite['idgite'] . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary" style="height: fit-content; margin-top: 10px;">Filtrer</button>
            <a href="index.php?page=gestion_reservation" class="btn btn-danger" style="height: fit-content; margin-top: 10px;">Réinitialiser</a>
        </form>

        <h3>Liste des Réservations (<?php echo count($reservations); ?>)</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dates</th>
                    <th>Gîte</th>
                    <th>Client</th>
                    <th>Prix Total (€)</th>
                    <th>Transport</th>
                    <th>Assurance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservations)): ?>
                    <tr><td colspan="8" style="text-align: center;">Aucune réservation trouvée.</td></tr>
                <?php endif; ?>
                <?php foreach ($reservations as $res): ?>
                <tr>
                    <td><?php echo $res['idreservation']; ?></td>
                    <td>Du <?php echo date('d/m/Y', strtotime($res['datedebut'])); ?> au <?php echo date('d/m/Y', strtotime($res['datefin'])); ?></td>
                    <td><?php echo $res['gite_adresse']; ?> (ID: <?php echo $res['idgite']; ?>)</td>
                    <td><?php echo $res['client_nom'] . ' ' . $res['client_prenom']; ?> (ID: <?php echo $res['idclient']; ?>)</td>
                    <td><?php echo number_format($res['prix'], 2, ',', ' '); ?></td>
                    <td><?php echo ucfirst($res['transport']); ?></td>
                    <td><?php echo $res['assurance'] == 1 ? 'Oui' : 'Non'; ?></td>
                    <td class="table-actions">
                        <a href="index.php?page=vue_insert_reservation&id=<?php echo $res['idreservation']; ?>" class="btn btn-warning">Modifier</a>
                        
                        <form method="POST" style="display:inline;" action="index.php?page=gestion_reservation">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $res['idreservation']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>