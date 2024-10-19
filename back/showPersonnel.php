<?php
// Connexion à la base de données
include_once '../back/bdd.php';

// Requête pour récupérer le personnel (sans le rôle admin)
$sql = "SELECT name, first_name, role, created_at FROM users WHERE role != 'admin'";
$result = $conn->query($sql);

// Vérification si des résultats ont été trouvés
if ($result->num_rows > 0) {
    // Afficher la liste du personnel
    echo '<div class="personnel-list">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="personnel-item">';
        echo '<span class="personnel-name">' . htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['first_name']) . '</span>';
        echo '<span class="personnel-role">(' . htmlspecialchars($row['role']) . ')</span>';
        echo '<span class="personnel-date">Inscrit le: ' . htmlspecialchars($row['created_at']) . '</span>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="edit-button"><img src="../img/icones/modif.png" alt="Modifier"></a>';
        echo '<a href="#" class="delete-button"><img src="../img/icones/supp.png" alt="Supprimer"></a>';
        echo '</div>'; // action-buttons
        echo '</div>'; // personnel-item
    }
    echo '</div>'; // personnel-list
} else {
    // Aucune donnée à afficher
    echo '<p>Aucun personnel à afficher.</p>';
}

// Fermer la connexion
$conn->close();
?>
