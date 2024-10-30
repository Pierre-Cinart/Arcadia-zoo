<?php
// connexion à la base de données
 include_once './config.php';
 $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
// Les données de l'utilisateur à insérer
$name = 'José';
$first_name = 'Admin';
$password = 'MotDePasse123'; 
$email = 'jose.admintest2@example.com';
$role = 'admin';

// Hacher le mot de passe pour la sécurité
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO users ( first_name, name, password, email, role) VALUES (?, ?, ?, ?, ?)";
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
