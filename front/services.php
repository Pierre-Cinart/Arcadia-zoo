<?php
session_start();
include_once "../back/bdd.php"; // Fichier pour la connexion à la BDD
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; ?> 
    </header>
    <main>
        <h1>Nos Services</h1>
        <section class="services">
            <?php
            // Préparation de la requête pour récupérer les services
            $sql = "SELECT name, description, picture FROM services";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Boucle pour chaque service
                while ($row = $result->fetch_assoc()) {
                    // Récupération des données
                    $name = htmlspecialchars($row['name']);
                    $description = htmlspecialchars($row['description']);
                    $picture = htmlspecialchars($row['picture']);
                    $imagePath = "../img/services/" . $picture . ".webp"; // Génération du chemin de l'image

                    // Affichage du service
                    echo "<div class='service'>";
                    echo "<h3>$name</h3>";
                    echo "<img src='$imagePath' alt='$name'>";
                    echo "<p>$description</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucun service disponible pour le moment.</p>";
            }

            // Fermeture de la connexion
            $conn->close();
            ?>
        </section>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>
