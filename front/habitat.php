<?php
session_start();
include_once('../back/bdd.php');

// Récupère l'ID de l'habitat depuis le paramètre GET et vérifie s'il est valide
if (isset($_GET['habitat_id']) && is_numeric($_GET['habitat_id'])) {
    $habitatId = intval($_GET['habitat_id']);

    // Requête pour vérifier si l'habitat existe
    $sql = "SELECT name, title_txt, description, picture FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $habitatId);
    $stmt->execute();
    $result = $stmt->get_result();
    $habitat = $result->fetch_assoc();

    // Si l'habitat n'est pas trouvé, redirige vers habitats.php
    if (!$habitat) {
        header("Location: habitats.php");
        exit();
    }

    // Requête pour récupérer les races liées à cet habitat
    $sqlRaces = "SELECT id, name FROM races WHERE habitat = ?";
    $stmtRaces = $conn->prepare($sqlRaces);
    $stmtRaces->bind_param("i", $habitatId);
    $stmtRaces->execute();
    $resultRaces = $stmtRaces->get_result();

    // Tableau pour stocker les races avec leur image et nom d'animal associé
    $races = [];
    while ($race = $resultRaces->fetch_assoc()) {
        $race_id = $race['id'];

        // Requête pour récupérer le nom de l'animal et l'image associée
        $sqlImage = "SELECT a.name AS animal_name, ap.name AS picture_name
                     FROM animals a
                     JOIN animal_pictures ap ON ap.animal_id = a.id
                     WHERE a.race_id = ?
                     ORDER BY ap.id DESC LIMIT 1";
        $stmtImage = $conn->prepare($sqlImage);
        $stmtImage->bind_param("i", $race_id);
        $stmtImage->execute();
        $resultImage = $stmtImage->get_result();
        
        // Assigner l'image et le nom de l'animal si trouvés, sinon mettre une image par défaut
        if ($resultImage->num_rows > 0) {
            $imageData = $resultImage->fetch_assoc();
            $race['image'] = '../img/animaux/' . htmlspecialchars($imageData['animal_name']) . '/' . htmlspecialchars($imageData['picture_name']);
        } else {
            $race['image'] = '../img/default_animal_image.webp'; // Image par défaut
        }
        
        $races[] = $race;
    }
} else {
    // Si l'ID est invalide, redirige vers habitats.php
    header("Location: habitats.php");
    exit();
}
?>

<!-- Partie HTML inchangée -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title><?php echo htmlspecialchars($habitat['title_txt']); ?></title>
    <style>
          
        /* Style body */
        body {
            min-height: 100vh;
            display: flex;
            justify-content: space-between;
            background-image: url('../img/habitats/<?php echo htmlspecialchars($habitat['picture']); ?>.webp');
            background-size: cover;
            background-position: center;
            color: white;
        }
        /* Style container du titre  */
        .container {
            position: relative;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7); /* Fond transparent pour le texte */
            max-width: 800px;
            margin: auto;
            border-radius: 10px;
            font-weight: normal;
        }
        .animals_list {
            list-style: none;
            margin: 0 auto; /* Centre la liste horizontalement */
            text-align: left;
            width: fit-content; /* Ajuste la largeur au contenu */
        }

        li {
            display: flex;
            align-items: center; /* Centre l'image et le texte verticalement */
            margin: 10px 0;
        }

        .animals_list img {
            margin-right: 10px; /* Espace entre l'image et le texte */
            vertical-align: middle;
        }

        a {
            color:white;
            text-decoration : none;
        }
    
        h3 {
            text-decoration: underline;
        }
    </style>
   
</head>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; ?>
    </header>
    <main>
        <div class="container">
            <h1><?php echo htmlspecialchars($habitat['title_txt']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars_decode($habitat['description'])); ?></p>
        </div>
        
        <div class="container" style="text-align: center;">
            <h3>Animaux dans cet habitat :</h3>
            <?php
            if (count($races) > 0) {
                echo '<ul class="animals_list">';
                foreach ($races as $race) {
                    echo '<li><a href="./animaux.php?id=' . htmlspecialchars($race['id']) . '">';
                    echo htmlspecialchars($race['name']) . ' : <img src="' . htmlspecialchars($race['image']) . 
                         '.webp" alt="' . htmlspecialchars($race['name']) . '" width="100"></a></li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Aucune race disponible dans cet habitat.</p>';
            }
            ?>
        </div>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>
