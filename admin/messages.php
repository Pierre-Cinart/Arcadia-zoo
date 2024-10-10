<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administateur</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <main class="admin">
    <h1>Consulter les messages</h1>
        <h2>Messages en attente : </h2>
    </main>
    
    <script src="../js/toggleMenu.js"></script>
</body>
</html>