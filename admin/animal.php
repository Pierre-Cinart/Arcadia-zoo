<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' 
|| $_SESSION['role'] !== 'agent' 
|| $_SESSION['role'] !== 'veterinaire')) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité , veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
    // Connexion à la base de données
    include_once './bdd.php';
    // pour utilisation de token
    include_once './token.php';
    checkToken($conn);// verifie si le token de session est correct et le met à jour
}
?>
afficher l animal concerné et les options disponibles selon les droits