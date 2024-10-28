<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <?php include_once "./btnBack.php"; ?> <!-- fonction pour bouton de retour -->
    <header>
    <?php include_once "../php/navbarr.php"; ?> <!-- navbarr -->
    </header>
    <main>
    <?php back('../index') ?> <!-- navbarr -->
        <h1>Accueil</h1>
        <h2>Aracadia-zoo</h2>
        <p>TEST BUTTON
        </p>
        <!-- injecter ici les trois derniers avis -->
        <?php include_once "../php/showAvis.php"; // (affichage provisoire )coder l affichage des trois derniers avis  ?>
        <a href="./avis.php"> voir tout les avis </a>
    </main>
    
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script> 
    <script src="../js/popup.js"></script>
</body>
</html>
