<?php
// Fonction pour ajouter un nouvel ID avec clicks = 0
function createNewClickId($type, $id) {
    // Déterminer le chemin du fichier JSON en fonction du type
    $filePath = '';
    if ($type === 'animal') {
        $filePath = '../data/clic_animal.json';
    } elseif ($type === 'race') {
        $filePath = '../data/clic_race.json';
    } else {
        echo "Type non valide.";
        return;
    }

    // Charger les données JSON existantes
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
    } else {
        // Initialiser un tableau vide si le fichier n'existe pas
        $data = [];
    }

    // Ajouter un nouvel ID avec clicks = 0
    if (!isset($data[$id])) {
        $data[$id] = ['clicks' => 0];
        
        // Enregistrer les données mises à jour dans le fichier JSON
        if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "ID ajouté avec succès dans $filePath.";
        } else {
            echo "Erreur lors de l'écriture dans le fichier $filePath.";
        }
    } else {
        echo "L'ID existe déjà dans $filePath.";
    }
}

// Fonction pour ajouter un clic à un ID existant
function addClick($type, $id) {
    // Déterminer le chemin du fichier JSON en fonction du type
    $filePath = '';
    if ($type === 'animal') {
        $filePath = '../data/clic_animal.json';
    } elseif ($type === 'race') {
        $filePath = '../data/clic_race.json';
    } else {
        echo "Type non valide.";
        return;
    }

    // Charger les données JSON existantes
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
    } else {
        echo "Le fichier $filePath n'existe pas.";
        return;
    }

    // Vérifier si l'ID existe dans les données
    if (isset($data[$id])) {
        // Incrémenter le nombre de clics pour cet ID
        $data[$id]['clicks']++;

        // Enregistrer les données mises à jour dans le fichier JSON
        if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "Clic ajouté avec succès pour l'ID $id dans $filePath.";
        } else {
            echo "Erreur lors de l'écriture dans le fichier $filePath.";
        }
    } else {
        echo "L'ID $id n'existe pas dans $filePath.";
    }
}
?>


