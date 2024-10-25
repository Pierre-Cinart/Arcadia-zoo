<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || !isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' || $_SESSION['role'] !== 'agent'  ) {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
}
// Vérification de l id et assignation à user_id
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
}
?>
coder l a jout d animal