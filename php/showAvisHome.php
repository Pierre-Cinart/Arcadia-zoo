<?php
// Connexion à la base de données
include_once '../back/bdd.php';
$limit = 3;
// Requête SQL pour compter le nombre total d'avis validés pour calculer le nombre de pages
$sqlCount = "SELECT COUNT(*) AS total FROM avis WHERE isVisible = TRUE";
$resultCount = $conn->query($sqlCount);




// Requête SQL pour récupérer les avis validés (LIMIT et OFFSET)
$sql = "SELECT pseudo, commentaire, created_at FROM avis WHERE isVisible = TRUE LIMIT ? ";
$stmt = $conn->prepare($sql); // Préparer la requête pour éviter les injections SQL
$stmt->bind_param('i', $limit); // Associer les paramètres à la requête (limite et offset)
$stmt->execute(); // Exécuter la requête
$result = $stmt->get_result(); // Récupérer le résultat de la requête

// Vérifier si des avis ont été trouvés
if ($result->num_rows > 0) {
    echo '<div id = "pagination" class="avis-container" >'; // Container pour les avis avec l'ID pagination
    while ($row = $result->fetch_assoc()) {
        // Formater la date au format désiré
        $dateTime = new DateTime($row['created_at']);
        $formattedDate = $dateTime->format('d-m-Y à H:i:s');
        echo '<div class="avis">';
        echo '<h4>' . htmlspecialchars($row['pseudo']) . ' :</h4>'; // Afficher le pseudo
        echo '<p>' . htmlspecialchars($row['commentaire']) . '</p>'; // Afficher le commentaire
        echo '<small>Publié le ' . htmlspecialchars($formattedDate) . '</small>'; // Date de publication
        echo '</div>'; // Fin de l'avis
    }
    echo '</div>'; // Fin du container
} else {
    // Si aucun avis n'est trouvé, afficher un message approprié
    echo '<p style="text-align:center; width:100%">Aucun avis pour le moment</p>';
}

// Fermer la requête préparée
$stmt->close();

// Fermeture de la connexion à la base de données
$conn->close();
?>
