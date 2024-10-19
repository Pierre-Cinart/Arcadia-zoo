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
    <?php include_once "../php/navbarr.php"; ?> <!-- navbarr -->
    </header>
    <main>
        <h1>Les avis de nos visiteurs</h1>
        <!-- affichage des  avis stocké en bdd -->
        <?php include_once '../php/showAvis.php'; ?>
        <form id="avis-form">
        <h3>Laissez votre avis : </h3>
        <br>
            <label for="name">nom ou pseudo:</label>
            <input type="text" id="name" required>

            <label for="avis">Votre avis :</label>
            <textarea id="avis" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>