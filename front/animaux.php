<?php
session_start();
// Inclusion des fichiers nécessaires
include_once('../back/bdd.php'); // Connexion à la base de données
include_once "../php/btnBack.php"; // Fonction pour le bouton de retour

// Récupère l'ID de l'habitat depuis le paramètre GET et vérifie s'il est valide pour assigner le background
if (isset($_GET['habitat']) && is_numeric($_GET['habitat'])) {
    $habitatId = intval($_GET['habitat']);
    
    // Requête SQL pour vérifier si l'habitat existe et récupérer l'image associée
    $sql = "SELECT picture FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $habitatId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Si l'habitat existe, l'image est récupérée. Sinon, une image par défaut est utilisée.
    $habitatPicture = $row ? $row['picture'] : 'bg'; 
}

// Récupère l'ID de la race et les informations des animaux si la race est valide
$animals = []; // Tableau pour stocker les animaux et leurs informations
if (isset($_GET['race_id']) && is_numeric($_GET['race_id'])) {
    $race_id = intval($_GET['race_id']);
    
    // Requête SQL pour récupérer les animaux associés à cette race
    $sqlAnimals = "SELECT id, name, description FROM animals WHERE race_id = ?";
    $stmtAnimals = $conn->prepare($sqlAnimals);
    $stmtAnimals->bind_param("i", $race_id);
    $stmtAnimals->execute();
    $resultAnimals = $stmtAnimals->get_result();
    
    // Parcourt chaque animal et récupère ses images associées
    while ($animal = $resultAnimals->fetch_assoc()) {
        $animal_id = $animal['id'];
        
        // Requête SQL pour obtenir toutes les images de cet animal
        $sqlImages = "SELECT name AS picture_name FROM animal_pictures WHERE animal_id = ?";
        $stmtImages = $conn->prepare($sqlImages);
        $stmtImages->bind_param("i", $animal_id);
        $stmtImages->execute();
        $resultImages = $stmtImages->get_result();

        // Récupère toutes les images pour cet animal et les ajoute au tableau
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
    <link rel="stylesheet" href="../css/style.css"> <!-- Fichier CSS principal -->
</head>
<style>
    body {
        min-height: 100vh;
        display: flex;
        justify-content: space-between;
        background-image: url('../img/habitats/<?php echo htmlspecialchars($habitatPicture); ?>.webp'); /* Image de fond dynamique */
        background-size: cover;
        background-position: center;
        color: white;
    }
    /* Conteneur pour les animaux */
    .animal-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    /* Element de chaque animal */
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
    /* Section des images supplémentaires, masquées par défaut */
    .additional-images {
        display: none; /* Masqué par défaut */
        margin-top: 10px;
    }
    .additional-images img {
        width: 100%;
        margin-top: 5px;
        border-radius: 5px;
    }
    /* Description de l'animal, masquée au départ */
    .animal-description {
        display: none; /* Masquée par défaut */
        margin-top: 10px;
        color: #f5f5f5;
        font-size: 14px;
    }
    /* Styles pour les écrans mobiles et tablettes */
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
        <?php include_once "../php/navbarr.php"; ?> <!-- Barre de navigation -->
    </header>
    <main>
        <br>
        <!-- Conteneur des animaux -->
        <div class="animal-container">
        <?php
// Vérifie si des animaux sont trouvés pour la race donnée
if (!empty($animals)) {
    foreach ($animals as $index => $animal) {
        echo '<div class="animal-item">';
        echo '<h3>' . htmlspecialchars($animal['name']) . '</h3>';

        // Affiche la première image de l'animal
        if (!empty($animal['pictures'])) {
            echo '<img src="' . htmlspecialchars($animal['pictures'][0]) . '" alt="' . htmlspecialchars($animal['name']) . '">';
            echo back('./habitats', 'r'); // Bouton de retour
        }

        // Section pour la description, masquée par défaut
        echo '<div class="animal-description" id="description-' . $index . '">';
        echo '<p>' . htmlspecialchars($animal['description']) . '</p>';
        echo '</div>';
        
        // Récupère l'ID de l'animal
        $aID = htmlspecialchars($animal['id']);

        // Affiche le bouton "Voir plus"
        echo '<button onclick="toggleContent(' . $index . ')" 
            id="toggle-button-' . $index . '" class="toggle-button" 
            data-id="' . $aID . '">Voir plus</button>';

        // Section des images supplémentaires
        echo '<div class="additional-images" id="images-' . $index . '">';
        foreach ($animal['pictures'] as $i => $picture) {
            if ($i > 0) { // Affiche seulement les images supplémentaires (pas la première)
                echo '<img src="' . htmlspecialchars($picture) . '" alt="' . htmlspecialchars($animal['name']) . '"><br>';
            }
        }
        echo '</div>'; // Fin de la section des images supplémentaires
        
        echo '</div>'; // Fermeture de l'animal-item
    }
} else {
    echo '<div><p>Aucun animal trouvé pour cette race.</p>';
    echo back('./habitats', 'r'); // Affiche un bouton de retour
    echo '</div>';
}
?>

            ?>
        </div>
    </main>
    <!-- Pied de page -->
    <?php include_once "../php/footer.php"; ?>
    
    <script src="../js/toggleMenu.js"></script> <!-- Script pour le menu responsive -->
    <script src="../js/clicks.js"></script> <!-- Script pour la gestion des clics -->
    <script>
    // Fonction pour afficher/masquer les images supplémentaires et la description
    function toggleContent(index) {
    const imageContainer = document.getElementById('images-' + index);
    const descriptionContainer = document.getElementById('description-' + index);
    const toggleButton = document.getElementById('toggle-button-' + index);
    
    // Récupère l'ID à partir de l'attribut 'data-id' du bouton
    const id = toggleButton.getAttribute('data-id');
    // Si le texte du bouton est 'Voir plus', on appelle addClick
    if (toggleButton.textContent === 'Voir plus') {
        addClick('animal', id);
    }
    // Toggle pour les images
    if (imageContainer.style.display === 'none' || imageContainer.style.display === '') {
        imageContainer.style.display = 'block';
        toggleButton.textContent = 'Voir moins';
    } else {
        imageContainer.style.display = 'none';
        toggleButton.textContent = 'Voir plus';
    }

    // Toggle pour la description
    if (descriptionContainer.style.display === 'none' || descriptionContainer.style.display === '') {
        descriptionContainer.style.display = 'block';
    } else {
        descriptionContainer.style.display = 'none';
    }

    
}


    </script>
</body>
</html>
