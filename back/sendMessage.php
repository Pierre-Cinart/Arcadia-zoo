<!-- coder l envoie de réponse au message du visiteur utiliser php mailer pour les reponses-->
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
    // verifie si le token de session est correct et le met à jour
    checkToken($conn);
    ?>