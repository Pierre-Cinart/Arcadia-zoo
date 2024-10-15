<?php
// Inclure le fichier de configuration
include '../config.php';

// Fonction pour créer un compte admin
function createAdminAccount($conn, $name, $firstName, $password) {
    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Requête SQL pour insérer le compte admin
    $sql = "INSERT INTO users (name, first_name, password, role) VALUES (?, ?, ?, 'admin')";
    
    // Préparer et exécuter la requête
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $name, $firstName, $hashedPassword);
        if ($stmt->execute()) {
            echo "Le compte admin a été créé avec succès.";
        } else {
            echo "Erreur lors de la création du compte : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $conn->error;
    }
}