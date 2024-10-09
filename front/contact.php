<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
    <?php include_once "../php/navbarr.php"; ?> <!-- navbarr -->
    </header>
    <body>
    <main>
        <h1>Contact</h1>
        <h2>Si vous avez des questions ou souhaitez obtenir plus d'informations, veuillez remplir le formulaire ci-dessous</h2>
        <form id="contact-form">
            <label for="objet">Objet :</label>
            <input type="text" id="objet" required>

            <label for="message">Message :</label>
            <textarea id="message" required></textarea>

            <label for="email">Votre Email :</label>
            <input type="email" id="email" required>

            <button type="submit">Envoyer</button>
        </form>
        <br>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/contact.js"></script>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>