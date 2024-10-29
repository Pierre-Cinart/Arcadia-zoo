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
        
        <?php
        // Récupère les données du formulaire si elles sont enregistrées en session en cas d'erreur pour les pré-remplir
        $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
        ?>
        
        <!-- Formulaire de contact -->
        <form id="contact-form" action="../back/clientSendMessage.php" method="POST">
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

            <!-- Bouton reCAPTCHA pour protéger le formulaire des envois automatisés -->
            <button class="g-recaptcha" 
                data-sitekey="<?php echo $RECAPTCHA_PUBLIC_KEY; ?>" 
                data-callback="onSubmit"                            
                data-action="submit">Envoyer</button>

        </form>
        <br>
    </main>

    <!-- footer -->
    <?php include_once "../php/footer.php"; ?>
    
    <!--API reCAPTCHA de Google -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    
    <!-- Fonction JavaScript appelée par reCAPTCHA lorsque le formulaire est validé -->
    <script>
       function onSubmit(token) {
           // Soumet le formulaire une fois que le reCAPTCHA est validé
           document.getElementById("contact-form").submit();
       }
    </script>
    <script src="../js/toggleMenu.js"></script><!-- menu mobile -->
    <script src="../js/popup.js"></script> <!-- pop-ups de succès ou d'erreur -->
    
</body>
</html>
