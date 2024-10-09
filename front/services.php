<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; ?> <!-- navbarr -->
    </header>
    <main>
        <h1>Nos Services</h1>
        <section class="services">
            <div class="service">
                <h3>Restauration</h3>
                <img src="../img/services/resto.jpg" alt="Restauration">
                <p>Des points de restauration pour vous détendre et savourer un bon repas après votre visite.</p>
            </div>

            <div class="service">
                <h3>Visite guidée des habitats</h3>
                <img src="../img/services/visite.webp" alt="Visite guidée">
                <p>Participez à une visite guidée gratuite des habitats pour en apprendre plus sur nos animaux.</p>
            </div>

            <div class="service">
                <h3>Tour en petit train</h3>
                <img src="../img/services/train.webp" alt="Petit train">
                <p>Découvrez le parc en vous relaxant à bord de notre petit train qui fait le tour du zoo.</p>
            </div>
        </section>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>
