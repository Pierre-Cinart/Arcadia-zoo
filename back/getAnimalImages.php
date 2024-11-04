<?php
// back/getAnimalImages.php

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de connexion à la base de données
include '../back/bdd.php';

// Vérifier si l'ID de l'animal est fourni
if (isset($_GET['animalId'])) {
    $animalId = (int)$_GET['animalId'];

    // Préparer la requête pour récupérer le nom de l'animal par son ID
    $animalStmt = $conn->prepare("SELECT name FROM animals WHERE id = ?");
    $animalStmt->bind_param('i', $animalId); // 'i' pour un entier
    $animalStmt->execute();
    
    // Récupérer le résultat
    $animalResult = $animalStmt->get_result();
    $animalData = $animalResult->fetch_assoc();

    // Vérifier si l'animal a été trouvé
    if ($animalData) {
        $nameId = $animalData['name']; // Récupérer le nom de l'animal
    } else {
        echo json_encode(['error' => 'Animal non trouvé']);
        exit; // Terminer le script si l'animal n'est pas trouvé
    }

    // Préparer la requête pour récupérer les images de l'animal par ID
    $stmt = $conn->prepare("SELECT name FROM animal_pictures WHERE animal_id = ?");
    $stmt->bind_param('i', $animalId); // 'i' pour un entier
    $stmt->execute();
    
    // Récupérer le résultat
    $result = $stmt->get_result();
    
    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row; // Ajouter chaque ligne au tableau d'images
    }

    // Retourner le nom de l'animal et les images en format JSON
    header('Content-Type: application/json');
    echo json_encode(['nameId' => $nameId, 'images' => $images]);
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'Aucun ID d\'animal fourni']);
}
?>
