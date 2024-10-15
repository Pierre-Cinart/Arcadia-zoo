<?php
// connexion à la base de données
include './bdd.php';

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et échapper les données du formulaire
    $name = htmlspecialchars(trim($_POST['name']));
    $firstName = htmlspecialchars(trim($_POST['surname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password']; // Le mot de passe n'est pas échappé
    $confirmPassword = $_POST['confirmPassword'];
    $role = htmlspecialchars(trim($_POST['role']));

    // Validation de mot de passe
    if ($password !== $confirmPassword) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Requête SQL pour insérer le compte
    $sql = "INSERT INTO users (name, first_name, email, password, role) VALUES (?, ?, ?, ?, ?)";

    // Préparer et exécuter la requête
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $name, $firstName, $email, $hashedPassword, $role);
        if ($stmt->execute()) {
            echo "Le compte a été créé avec succès.";
        } else {
            echo "Erreur lors de la création du compte : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $conn->error;
    }
} else {
    echo "Méthode de requête non valide.";
}

// Fermer la connexion
$conn->close();
?>
