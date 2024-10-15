<?php
// Inclure le fichier de connexion à la base de données
include '../back/bdd.php';

// Créer une requête pour récupérer la description
$sql = "SELECT description FROM horaires";
$result = $conn->query($sql);

// Vérifiez si des résultats ont été renvoyés
if ($result->num_rows > 0) {
    // Récupérer la première ligne de résultats
    $row = $result->fetch_assoc();
    // Remplacer les '#' par des balises <br>
    $description = str_replace('#', '<br>', $row['description']);
    
    // Afficher la description dans un paragraphe
    echo "<p>" . $description . "</p>";
} else {
    echo "Aucune description trouvée.";
}

// Fermer la connexion
$conn->close();
?>
