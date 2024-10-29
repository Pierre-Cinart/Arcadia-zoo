<?php
session_start();

//  fichier de configuration de reCAPTCHA
include_once('../configCaptcha.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Avis</title> 
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; // navbar ?>  
    </header>
    
    <?php include_once "../php/popup.php"; ?><!-- pop-up pour afficher les messages d'erreur ou de succès -->

    <main>
        <h1>Les avis de nos visiteurs</h1> 
        
        <!--  liste des avis depuis la base de données -->
        <?php include_once '../php/showAvis.php'; ?> 
        <br>

        <!-- Formulaire pour  soumettre un avis -->
        <form id="avis-form" method="POST" action="../back/sendAvis.php">
            <h3>Laissez votre avis :</h3> 
            <br>

            <!-- nom ou pseudo de l'utilisateur -->
            <label for="name">Nom ou pseudo :</label>
            <input type="text" id="name" name="name" required> 

            <!--  avis de l'utilisateur -->
            <label for="avis">Votre avis :</label>
            <textarea id="avis" name="avis" required></textarea>

            <!-- Bouton reCAPTCHA pour protéger le formulaire des envois automatisés -->
            <button 
                class="g-recaptcha" 
                data-sitekey="<?php echo $RECAPTCHA_PUBLIC_KEY; ?>" 
                data-callback="onSubmit" 
                data-action="submit">
                Envoyer
            </button>
        </form>
    </main>

    <!-- footer -->
    <?php include_once "../php/footer.php"; ?>

    <!-- Script pour charger l'API reCAPTCHA de Google -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    
    <!-- Fonction JavaScript appelée par reCAPTCHA lorsque le formulaire est validé -->
    <script>
       function onSubmit(token) {
           // Soumet le formulaire une fois que le reCAPTCHA est validé
           document.getElementById("avis-form").submit();
       }
    </script>
    <script src="../js/popup.js"></script>   <!-- pop-ups de messages de succès ou d'erreur -->
    <script src="../js/toggleMenu.js"></script> <!--  menu mobile -->
</body>
</html>
