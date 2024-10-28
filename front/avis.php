<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
    <?php include_once "../php/navbarr.php"; 
    if (isset($_SESSION['postMsg'])){
        var_dump($_SESSION['postMsg']);}?> <!-- navbarr -->
    </header>
    <?php include_once "../php/popup.php"; ?> <!-- popup messages -->
    <main>
        <h1>Les avis de nos visiteurs</h1>
        <!-- affichage des  avis stocké en bdd -->
        <?php include_once '../php/showAvis.php'; ?>
        <br>
        <form id="avis-form" method="POST" action="../back/sendAvis.php">
            <h3>Laissez votre avis : </h3>
            <br>
            <label for="name">Nom ou pseudo:</label>
            <input type="text" id="name" name="name" required>

            <label for="avis">Votre avis :</label>
            <textarea id="avis" name="avis" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/popup.js"></script>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>