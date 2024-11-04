<?php
session_start();
include_once('../back/bdd.php');
// pour les boutons retour
include_once "../php/btnBack.php"; 

// Récupère l'ID de l'habitat depuis le paramètre GET et vérifie s'il est valide pour assigner le background
if (isset($_GET['habitat']) && is_numeric($_GET['habitat'])) {
    $habitatId = intval($_GET['habitat']);
    // Requête pour vérifier si l'habitat existe et obtenir l'image
    $sql = "SELECT picture FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $habitatId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Assigne le background si l'habitat existe, sinon une image par défaut
    $habitatPicture = $row ? $row['picture'] : 'bg';
}

// Récupère l'ID de la race et les informations des animaux si la race est valide
$animals = []; // Tableau pour stocker les animaux et leurs informations
if (isset($_GET['race_id']) && is_numeric($_GET['race_id'])) {
    $race_id = intval($_GET['race_id']);

    // Requête pour récupérer les animaux associés à cette race
    $sqlAnimals = "SELECT id, name, description FROM animals WHERE race_id = ?";
    $stmtAnimals = $conn->prepare($sqlAnimals);
    $stmtAnimals->bind_param("i", $race_id);
    $stmtAnimals->execute();
    $resultAnimals = $stmtAnimals->get_result();

    // Parcourt chaque animal et récupère ses images
    while ($animal = $resultAnimals->fetch_assoc()) {
        $animal_id = $animal['id'];

        // Requête pour obtenir toutes les images de cet animal
        $sqlImages = "SELECT name AS picture_name FROM animal_pictures WHERE animal_id = ?";
        $stmtImages = $conn->prepare($sqlImages);
        $stmtImages->bind_param("i", $animal_id);
        $stmtImages->execute();
        $resultImages = $stmtImages->get_result();

        // Récupère toutes les images pour cet animal
        $pictures = [];
        while ($imageData = $resultImages->fetch_assoc()) {
            $pictures[] = '../img/animaux/' . htmlspecialchars($animal['name']) . '/' . htmlspecialchars($imageData['picture_name']) . '.webp';
        }

        $animal['pictures'] = $pictures;
        $animals[] = $animal;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitats</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>
    body {
        min-height: 100vh;
        display: flex;
        justify-content: space-between;
        background-image: url('../img/habitats/<?php echo htmlspecialchars($habitatPicture); ?>.webp');
        background-size: cover;
        background-position: center;
        color: white;
    }
    .animal-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .animal-item {
        background: rgba(0, 0, 0, 0.7);
        border-radius: 10px;
        padding: 10px;
        width: 40%;
        text-align: center;
        color: white;
    }
    .animal-item img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
    }
    .additional-images {
        display: none; /* Masquer par défaut */
        margin-top: 10px;
    }
    .additional-images img {
        width: 100%;
        margin-top: 5px;
        border-radius: 5px;
    }
    /* MOBILE ET TABLETTE*/
    @media (max-width: 820px) {
        .animal-item {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 10px;
            width: 90%;
            text-align: center;
            color: white;
        }
    }
</style>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; ?>
    </header>
    <main>
        <br>
        <div class="animal-container">
            <?php
           if (!empty($animals)) {
            foreach ($animals as $index => $animal) {
                echo '<div class="animal-item">';
                echo '<h3>' . htmlspecialchars($animal['name']) . '</h3>';
                // Affiche la première image par défaut
                if (!empty($animal['pictures'])) {
                    echo '<img src="' . htmlspecialchars($animal['pictures'][0]) . '" alt="' . htmlspecialchars($animal['name']) . '">';
                    echo back('./habitats','r');
                }
                echo '<p>' . htmlspecialchars($animal['description']) . '</p>';
                
                // Affiche le bouton seulement s'il y a plus d'une image
                if (count($animal['pictures']) > 1) {
                    echo '<button onclick="toggleImages(' . $index . ')" id="toggle-button-' . $index . '">Voir plus</button>';
                    
                    // Section des images supplémentaires, masquées au départ
                    echo '<div class="additional-images" id="images-' . $index . '">';
                    foreach (array_slice($animal['pictures'], 1) as $picture) {
                        echo '<img src="' . htmlspecialchars($picture) . '" alt="' . htmlspecialchars($animal['name']) . '"><br>';
                    }
                    echo '</div>';
                }
        
                echo '</div>';
            }
        } else {
            echo '<div><p>Aucun animal trouvé pour cette race.</p>';
            echo back('./habitats','r');
            echo '</div>';
        }
        ?>
        </div>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
    <script>
    // Fonction pour afficher ou masquer les images supplémentaires
    function toggleImages(index) {
        const imageContainer = document.getElementById('images-' + index);
        const toggleButton = document.getElementById('toggle-button-' + index);
        
        if (imageContainer.style.display === 'none' || imageContainer.style.display === '') {
            imageContainer.style.display = 'block';
            toggleButton.textContent = 'Voir moins';
        } else {
            imageContainer.style.display = 'none';
            toggleButton.textContent = 'Voir plus';
        }
    }
</script>

</body>
</html>
