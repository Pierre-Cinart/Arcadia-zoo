<?php
header('Content-Type: application/json');

// Incrémente les clicks pour les stats
function addClick($type, $id) {
    $filePath = getFilePath($type);
    if (!$filePath) {
        return ['success' => false, 'message' => 'Type non valide.'];
    }

    $data = loadData($filePath);
    if (!isset($data[$id])) {
        $data[$id] = ['clicks' => 0];
    }
    $data[$id]['clicks']++;

    if (saveData($filePath, $data)) {
        return ['success' => true, 'clicks' => $data[$id]['clicks']];
    } else {
        return ['success' => false, 'message' => "Erreur lors de l'écriture dans le fichier."];
    }
}

// Supprime les données si animal ou race est effacé
function deleteId($type, $id) {
    $filePath = getFilePath($type);
    if (!$filePath) {
        return ['success' => false, 'message' => 'Type non valide.'];
    }

    $data = loadData($filePath);
    if (isset($data[$id])) {
        unset($data[$id]);
        if (saveData($filePath, $data)) {
            return ['success' => true, 'message' => "ID supprimé avec succès."];
        } else {
            return ['success' => false, 'message' => "Erreur lors de l'écriture dans le fichier."];
        }
    } else {
        return ['success' => false, 'message' => "L'ID n'existe pas."];
    }
}

function getFilePath($type) {
    return $type === 'animal' ? '../data/clic_animal.json' : ($type === 'race' ? '../data/clic_race.json' : '');
}

function loadData($filePath) {
    return file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];
}

function saveData($filePath, $data) {
    return file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}

// Récupérer les paramètres et appeler la fonction correspondante
$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? '';
$action = $_GET['action'] ?? '';

$response = [];
if ($type && $id) {
    switch ($action) {
        case 'add':
            $response = addClick($type, $id);
            break;
        case 'delete':
            $response = deleteId($type, $id);
            break;
        default:
            $response = ['success' => false, 'message' => 'Action non valide.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Paramètres manquants.'];
}

echo json_encode($response);
?>
