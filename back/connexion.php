<?php
session_start();

// Inclure la connexion à la base de données
include_once 'bdd.php';
// pour creation de token
include_once './Token.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et échapper les données du formulaire
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Vérifier si l'email et le mot de passe ne sont pas vides
    if (!empty($email) && !empty($password)) {
        // Préparer une requête pour récupérer l'utilisateur correspondant à l'email
        $sql = "SELECT id, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Si un utilisateur avec cet email est trouvé
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashed_password = $user['password'];
            $user_id = $user['id'];
            $user_role = $user['role'];

            // Vérifier si le mot de passe est correct
            if (password_verify($password, $hashed_password)) {
                //creer le token
                $token = createToken($conn , $token , $user_id );
                // Mettre à jour le token et l'expiration (ajout de 2 heures avec CURRENT_TIMESTAMP)
                updateToken($conn,$token,$user_id);

                // Stocker les informations dans la session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['token'] = $token;
                $_SESSION['role'] = $user_role;
                $_SESSION['success'] = "Vous êtes connecter en " . $_SESSION['role'];
                // Rediriger vers la page animaux par défaut
                header('Location: ../admin/animaux.php');
                exit();
            } else {
                // Mot de passe incorrect
                $_SESSION['error'] = "Mot de passe incorrect.";
                // Rediriger vers la page de connexion
                header('Location: ../admin/index.php');
            }
        } else {
            // Email non trouvé
            $_SESSION['error'] = "Aucun utilisateur trouvé avec cet email.";
            header('Location: ../admin/index.php');
        }

        // Fermer la requête
        $stmt->close();
    } else {
        // Email ou mot de passe vide
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
    }
}

// Fermer la connexion
$conn->close();
?>
