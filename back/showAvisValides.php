<?php
// Inclure la connexion à la base de données
include_once '../back/bdd.php';

// Requête pour récupérer les avis validés
$sql = "SELECT id, pseudo, commentaire, created_at FROM avis WHERE isVisible = TRUE";
$result = $conn->query($sql);

// Vérifier si des avis validés ont été trouvés
if ($result->num_rows > 0) {
    echo '<div class="avis-container">'; // Container pour les avis
    while ($row = $result->fetch_assoc()) {
        // Formater la date au format désiré
        $dateTime = new DateTime($row['created_at']);
        $formattedDate = $dateTime->format('d-m-Y à H:i:s');

        echo '<div class="avis">';
        echo '<h4>' . htmlspecialchars($row['pseudo']) . ' : </h4>'; // Afficher le pseudo
        echo '<p>' . htmlspecialchars($row['commentaire']) . '</p>'; // Afficher le commentaire
        echo '<small>Publié le ' . htmlspecialchars($formattedDate) . '</small><br>'; // Date de publication
        
        // Ajouter l'icône de suppression
        echo '<div class="avis-actions">';
        echo '<a href="../back/deleteAvis.php?id=' . $row['id'] . '"><img src="../img/icones/supp.png" alt="Supprimer" title="Supprimer"></a>';
        echo '</div>'; // Fin des actions
        echo '</div>'; // Fin de l'avis
    }
    echo '</div>'; // Fin du container
} else {
    echo '<p style="text-align:center; width:100%">Aucun avis validé</p>'; // Message si aucun avis validé
}

// connexion Fermée sur la page concerné car requetes séparées 

?>