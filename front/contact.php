<?php
session_start();

// fichier de configuration de reCAPTCHA
include_once('../configCaptcha.php');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; ?> <!-- navbarr-->
    </header>
    <?php include_once "../php/popup.php"; ?>  <!-- pop-up pour les messages de succès ou d'erreur -->
    <main>
        <h1>Contact</h1>
        <h2>Si vous avez des questions ou souhaitez obtenir plus d'informations, veuillez remplir le formulaire ci-dessous</h2>
        
        <!-- Formulaire de contact -->
        <form id="contact-form">
            <!-- Champ pour le nom -->
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($form_data['name'] ?? '') ?>" required>

            <!-- Champ pour le prénom -->
            <label for="surname">Prénom :</label>
            <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($form_data['surname'] ?? '') ?>" required>

            <!-- Champ pour l'objet du message -->
            <label for="objet">Objet :</label>
            <input type="text" id="objet" name="objet" value="<?= htmlspecialchars($form_data['objet'] ?? '') ?>" required>

            <!-- Champ pour le message -->
            <label for="message">Message :</label>
            <textarea id="message" name="message" required><?= htmlspecialchars($form_data['message'] ?? '') ?></textarea>

            <!-- Champ pour l'email -->
            <label for="email">Votre Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($form_data['email'] ?? '') ?>" required>
            <h3>Contactez-nous directement par email :</h3>
            <h4>aracadia@zoo.com</h4>
            <button id="mailButton" onclick="sendMail()">Contacter par Email</button>
        </form>
     
        <br>

        <!-- Bouton de mailing qui va déclencher la fonction JS pour pré-remplir l'email -->
       
        
    </main>

    <!-- footer -->
    <?php include_once "../php/footer.php"; ?>
    
    <script src="../js/toggleMenu.js"></script><!-- menu mobile -->
    <script src="../js/popup.js"></script> <!-- pop-ups de succès ou d'erreur -->

    <!-- JavaScript pour créer le lien mailto: -->
    <script>
        function sendMail() {
            // Récupérer les valeurs du formulaire
            var name = document.getElementById("name").value;
            var surname = document.getElementById("surname").value;
            var objet = document.getElementById("objet").value;
            var message = document.getElementById("message").value;
            var email = document.getElementById("email").value;

            // Créer l'URL mailto avec les données récupérées
            var mailtoLink = "mailto:aracdia@zoo.com?subject=Demande d'information: " + encodeURIComponent(objet) +
                             "&body=Bonjour,%0A%0ANom: " + encodeURIComponent(name) + 
                             "%0APrénom: " + encodeURIComponent(surname) + 
                             "%0A%0A" + encodeURIComponent(message) +
                             "%0A%0ACordialement,%0A" + encodeURIComponent(name) + " " + encodeURIComponent(surname) + 
                             "%0A%0AEmail: " + encodeURIComponent(email);

            // Ouvrir le client email avec le lien mailto
            window.location.href = mailtoLink;
        }
    </script>
</body>
</html>
