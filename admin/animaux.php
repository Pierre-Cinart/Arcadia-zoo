<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitats</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de deconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    <main>
        
        <section class="habitat">
            <article>
                <!-- SAVANE -->
                <h2>La Savane</h2>
                <div class="habitat-card">
                    <img src="../img/habitats/Savane.webp" alt="savane">
                    <div class="habitat-card-txt">
                        
                        <ul class = "admin">
                            <li><strong>Simba</strong></li>
                            <li><strong>Nalah</strong></li>
                            <li><strong>Mumu</strong></li>
                            <li><strong>Dumbo</strong></li>
                        </ul>
                    </div>
                </div>
            </article>

            <article>
                <!-- JUNGLE -->
                <h2>La Jungle</h2>
                <div class="habitat-card">
                    <img src="../img/habitats/Jungle.webp" alt="jungle">
                    <div class="habitat-card-txt">
                        <ul class = "admin">
                            <li><strong>Sherkan</strong></li>
                            <li><strong>Singes capucins</strong></li>
                            <li><strong>Baguera</strong></li>
                        </ul>
                    </div>
                </div>
            </article>

            <article>
                <!-- MARAIS -->
                <h2>Les Marais</h2>
                <div class="habitat-card">
                    <img src="../img/habitats/Marais.webp" alt="marais">
                        <ul class = "admin">
                            <li><strong>Lacoste</strong></li>
                            <li><strong>Mamapo</strong></li>
                            <li><strong>Popa</strong></li>
                            <li><strong>Popi</strong></li>
                            <li><strong>Flamants roses</strong></li>
                        </ul>
                    </div>
                </div>
            </article>
        </section>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>
