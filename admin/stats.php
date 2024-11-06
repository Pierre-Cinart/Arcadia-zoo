<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis pour cette page.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else {
    $role = $_SESSION['role']; 
    // Connexion à la base de données
    include_once '../back/bdd.php';
    // Pour utilisation de token
    include_once '../back/token.php';
    checkToken($conn); // Vérifie si le token de session est correct et le met à jour
}

// Lecture des fichiers JSON
$racesData = json_decode(file_get_contents('../data/clic_race.json'), true);
$animalsData = json_decode(file_get_contents('../data/clic_animal.json'), true);

// Requête pour récupérer les races depuis la base de données
$queryRaces = "SELECT id, name FROM races";
$resultRaces = $conn->query($queryRaces);

// Requête pour récupérer les animaux depuis la base de données
$queryAnimals = "SELECT id, name FROM animals";
$resultAnimals = $conn->query($queryAnimals);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->

    <main class="admin" style="display: flex; flex-wrap: wrap; gap: 20px;justify-content:center;">
        <!-- Section pour les races -->
        <div class="races_stat" style="background-color:white;" >
            <h3>Races</h3>
            <?php while ($race = $resultRaces->fetch_assoc()) { 
                $raceId = $race['id'];
                $raceName = $race['name'];
                $raceClicks = isset($racesData[$raceId]) ? $racesData[$raceId]['clicks'] : 0;
            ?>
                <div class="item" style="margin: 10px; text-align: center;">
                    <p><?php echo htmlspecialchars($raceName); ?></p>
                    <p>Nombre de clics : <?php echo $raceClicks; ?></p>
                </div>
            <?php } ?>
        </div>

        <!-- Section pour les animaux -->
        <div class="animals_stat"  style="background-color:white;">
            <h3>Animaux</h3>
            <?php while ($animal = $resultAnimals->fetch_assoc()) { 
                $animalId = $animal['id'];
                $animalName = $animal['name'];
                $animalClicks = isset($animalsData[$animalId]) ? $animalsData[$animalId]['clicks'] : 0;
            ?>
                <div class="item" style="margin: 10px; text-align: center;">
                    <p><?php echo htmlspecialchars($animalName); ?></p>
                    <p>Nombre de clics : <?php echo $animalClicks; ?></p>
                </div>
            <?php } ?>
        </div>
    </main>

    <script src="../js/toggleMenu.js"></script> <!-- Navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- Popup (erreur ou succès de l'action) -->
</body>
</html>
