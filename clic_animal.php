<?php
// Inclure le fichier de configuration
include_once './config.php';

// Créer la connexion
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer tous les ID des animaux
$sql = "SELECT id FROM animals";
$result = $conn->query($sql);

// Vérifier s'il y a des résultats
if ($result === false) {
    die("Erreur lors de l'exécution de la requête : " . $conn->error);
} elseif ($result->num_rows > 0) {
    echo "Nombre de animals trouvées : " . $result->num_rows . "<br>";

    // Initialiser un tableau pour stocker les données
    $clicsData = [];

    // Pour chaque animal, ajouter un objet avec l'ID et les clics initialisés à 0
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        echo "Traitement de l'ID de la animal : $id<br>"; // Debugging line
        $clicsData[$id] = [
            'clicks' => 0
        ];
    }

    // Convertir le tableau en JSON
    $jsonData = json_encode($clicsData, JSON_PRETTY_PRINT);

    // Afficher le JSON pour vérifier le contenu
    echo "<pre>$jsonData</pre>"; // Debugging line

    // Chemin vers le fichier JSON (vérifier que le chemin est absolu)
    $filePath = __DIR__ . '/data/clic_animal.json';

    // Écrire le JSON dans le fichier
    if (file_put_contents($filePath, $jsonData) !== false) {
        echo "Données initialisées avec succès dans le fichier clic_animal.json.";
    } else {
        echo "Erreur lors de l'écriture dans le fichier clic_animal.json.";
    }
} else {
    echo "Aucune animal trouvée dans la base de données.";
}

// Fermer la connexion
$conn->close();
