<?php
// Inclure le fichier de configuration
include_once '../config.php';
// Créer la connexion
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}