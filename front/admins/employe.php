<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace employé</title>
    <link rel="stylesheet" href="../../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
    <?php include_once "../../php/navbarr.php"; ?> <!-- navbarr -->
        <h1>Espace employé</h1>
    </header>
    <main>
        <h2>Rapport nutritionnel</h2>
        <h3>habitat :</h3>
        <ul class = habitatsUl>
            <li>
                Marais 
            </li>
            <li>
                Jungle 
            </li>
            <li>
                Savane  
            </li>
            
        </ul>
    </main>
    <?php include_once "../../php/footer.php"; ?>
    <script src="../../js/toggleMenu.js"></script>
</body>
</html>