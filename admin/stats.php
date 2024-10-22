<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin')) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité , veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de deconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    <main class="admin">
        
    </main>
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>