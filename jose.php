<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include_once './back/bdd.php'; 

// Les données de l'utilisateur à insérer
$name = 'José';
$first_name = 'Admin';
$password = 'MotDePasse123'; 
$email = 'jose.admin@example.com';
$role = 'admin';

// Hacher le mot de passe pour la sécurité
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO users (name, first_name, password, email, role) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Vérifier la préparation de la requête
if ($stmt) {
    // Lier les paramètres aux valeurs
    $stmt->bind_param("sssss", $name, $first_name, $hashed_password, $email, $role);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "L'utilisateur José Admin a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();
} else {
    echo "Erreur de préparation de la requête : " . $conn->error;
}

// Fermer la connexion à la base de données
$conn->close();
?>
