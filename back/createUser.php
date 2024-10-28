<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' ||!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
}

// Connexion à la base de données
include_once './bdd.php';

// pour utilisation de token
include_once './token.php';

checkToken($conn);// verifie si le token de session est correct et le met à jour

// Initialisation des messages
$error_message = '';
$success_message = '';

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
        $error_message = "Les mots de passe ne correspondent pas."; // Enregistrer l'erreur
        
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        // Vérifier que le mot de passe a au moins une majuscule, un chiffre, un symbole et 8 caractères minimum
        $error_message = "Le mot de passe doit contenir au moins une majuscule, un chiffre, un symbole et être composé d'au moins 8 caractères.";
    } else {
   
        // Vérifier si l'email existe déjà
        $check_email_sql = "SELECT id FROM users WHERE email = ?";
        $check_email_stmt = $conn->prepare($check_email_sql);
        $check_email_stmt->bind_param("s", $email);
        $check_email_stmt->execute();
        $check_email_stmt->store_result();

        if ($check_email_stmt->num_rows > 0) {
            $error_message = "L'email est déjà utilisé."; // Enregistrer l'erreur
        }
        $check_email_stmt->close();
    }

    // Si aucune erreur, procéder à l'insertion
    if (empty($error_message)) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête SQL pour insérer le compte
        $sql = "INSERT INTO users (name, first_name, email, password, role) VALUES (?, ?, ?, ?, ?)";

        // Préparer et exécuter la requête
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $name, $firstName, $email, $hashedPassword, $role);
            if ($stmt->execute()) {
                $success_message = "Le compte a été créé avec succès."; // Enregistrer le succès
            } else {
                $error_message = "Erreur lors de la création du compte : " . $stmt->error; // Enregistrer l'erreur
            }
            $stmt->close();
        } else {
            $error_message = "Erreur de préparation de la requête : " . $conn->error; // Enregistrer l'erreur
        }
    }
   
    // Fermer la connexion
    $conn->close();

    // Enregistrer le popup dans la session
    if (!empty($success_message)) {
        $_SESSION['success'] = $success_message;
    } else if (!empty($error_message)) {
        $_SESSION['error'] = $error_message;
    }

    // Redirection vers la page de personnel
    header("Location: ../admin/personnel.php");
    exit();
} else {
    $_SESSION['error'] = "Méthode de requête non valide."; // Enregistrer l'erreur dans la session
    header("Location: ../admin/personnel.php"); // Rediriger vers la page de formulaire
    exit();
}
?>
