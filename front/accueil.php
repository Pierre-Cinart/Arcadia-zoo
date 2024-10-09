<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
    <?php include_once "../php/navbarr.php"; ?> <!-- navbarr -->
    </header>
    <main>
        <h1>Accueil</h1>
        <h2>Aracadia-zoo</h2>
        <p>Arcadia est un zoo situé en France, près de la forêt de Brocéliande en Bretagne, fondé en 1960. 
            Nous possédons une grande variété d'animaux répartis par habitat (savane, jungle, marais) et accordons une attention 
            particulière à leur santé. Chez Arcadia, le bien-être de nos animaux est notre priorité. Chaque jour, 
            plusieurs vétérinaires réalisent des contrôles sur chaque animal avant l'ouverture du zoo, afin de s'assurer 
            que tout se passe bien.
            Le parc propose également plusieurs services pour enrichir l'expérience de nos visiteurs. Vous pouvez profiter de nos 
            points de restauration pour vous détendre, participer à une visite guidée gratuite des habitats pour en apprendre
            davantage sur les espèces, ou encore découvrir le zoo à bord d'un petit train qui fait le tour du parc.
        </p>
        <?php include_once "../php/avis.php"; ?>
    </main>
    
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>
