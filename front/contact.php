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
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    <main>
        <h1>Contact</h1>
        <h2>Si vous avez des questions ou souhaitez obtenir plus d'informations, veuillez remplir le formulaire ci-dessous</h2>
        <?php
        // Récupérer les données du formulaire en cas d'erreur
        $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
        ?>
        <form id="contact-form" action="../back/clientSendMessage.php" method="POST">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($form_data['name'] ?? '') ?>" required>

            <label for="surname">Prénom :</label>
            <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($form_data['surname'] ?? '') ?>" required>

            <label for="objet">Objet :</label>
            <input type="text" id="objet" name="objet" value="<?= htmlspecialchars($form_data['objet'] ?? '') ?>" required>

            <label for="message">Message :</label>
            <textarea id="message" name="message" required><?= htmlspecialchars($form_data['message'] ?? '') ?></textarea>

            <label for="email">Votre Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($form_data['email'] ?? '') ?>" required>

            <button type="submit">Envoyer</button>
        </form>
        <br>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>
