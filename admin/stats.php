<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'La page que vous avez demandé requiert des droits administrateur.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
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
    <main class="admin">
        
    </main>
    
    <script src="../js/toggleMenu.js"></script>
</body>
</html>