<?php
// Inclure le fichier de configuration
include '../config.php';

define('DB_HOST', 'localhost');
define('DB_NAME', 'arcadia');
define('DB_USER', 'root');
define('DB_PASS', 'Critical+59200');

// Créer la connexion
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}