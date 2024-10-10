<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body >
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <main class="admin">
        <h1>Connexion</h1>
        <h2>Cette page est réservée au personnel</h2>
        <h3>Entrez votre identifiant et mot de passe pour vous connecter</h3>
        <form id="contact-form">

            <label for="email">Votre Email :</label>
            <input type="email" id="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" required></password>

            <button type="submit">Envoyer</button>
        </form>
        <br>
    </main>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>