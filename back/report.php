<?php
    session_start();

    // Vérification du rôle
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'agent ' && $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'veterinaire' )|| !isset($_SESSION['user_id'])) {
        $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
        header('Location: ../admin/index.php'); // Redirection vers la page de connexion
        exit();
    } else {
        $id = $_SESSION['user_id'];
        // Connexion à la base de données
    include_once './bdd.php';

    // pour utilisation de token
    include_once './token.php';

    checkToken($conn);// verifie si le token de session est correct et le met à jour
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    } else {
        $_SESSION['error'] = 'erreur de méthode';
        header('location:../admin/report.php');
        exit();
        
    }
    $conn->close();
    header('location:../admin/report.php');
    exit();
?>

