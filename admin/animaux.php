<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'agent', 'veterinaire'])) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis pour des raisons de sécurité, veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
    // Connexion à la base de données
    include_once '../back/bdd.php';
    include_once '../back/token.php';
    checkToken($conn); // Vérifie si le token de session est correct et le met à jour
}

// Récupérer les races d'animaux
$racesQuery = "SELECT id, name, regime FROM races";
$racesResult = $conn->query($racesQuery);
if ($racesResult) {
    $races = $racesResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Gérer l'erreur si la requête échoue
    $races = [];
    error_log("Erreur lors de la récupération des races : " . $conn->error);
}

// Récupérer les noms d'animaux
$animalsQuery = "SELECT id, name FROM animals";
$animalsResult = $conn->query($animalsQuery);
if ($animalsResult) {
    $animals = $animalsResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Gérer l'erreur si la requête échoue
    $animals = [];
    error_log("Erreur lors de la récupération des animals : " . $conn->error);
}

// Récupérer les habitats
$habitatsQuery = "SELECT id, name FROM habitats";
$habitatsResult = $conn->query($habitatsQuery);
if ($habitatsResult) {
    $habitats = $habitatsResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Gérer l'erreur si la requête échoue
    $habitats = [];
    error_log("Erreur lors de la récupération des habitats : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion animaux</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <?php include_once "../php/btnLogout.php"; ?>
    <?php include_once "../php/popup.php"; ?>
    <main class="admin">
        <div style="display: flex; justify-content: center; gap: 10px; margin: 20px;flex-wrap:wrap;">
            <?php 
                if ($role === 'admin' || $role === 'agent') {
                    echo '<a href="./habitats.php"><button id="modifHabitats">Gérer les habitats</button></a>';
                    echo '<button id="addAnimalBtn">Ajouter Un Animal</button>'; 
                    echo '<button id="modifAnimalBtn">Modifier des informations</button>'; 
                }
                echo '<a href="./reports.php"><button id="reportAnimalBtn">Gestion rapports</button></a>'; 
            ?>
        </div>
        
        <!-- Formulaire d'ajout d'animal -->
        <div id="addAnimalForm">
            <h3>Ajouter un animal</h3>
            <form action="../back/createAnimal.php" method="POST" enctype="multipart/form-data">
                <!-- choix du nom  -->
                <label for="name">Nom :</label>
                <input type="text" name="name" required><br>

                <!-- selection de race -->
                <label for="race">Race :</label>
                <select name="race" id="raceSelect" required>
                    <option value="">Sélectionnez une race</option>
                    <?php foreach ($races as $race): ?>
                        <option value="<?= htmlspecialchars($race['name']) ?>" data-regime="<?= htmlspecialchars($race['regime']) ?>">
                            <?= htmlspecialchars($race['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="Autre">Autre (ajouter une nouvelle race)</option>
                </select>

                <!-- nouvelle race  / s affiche si choix 'Autre' sur race  -->
                <input type="text" name="newRace" id="newRaceInput" placeholder="Entrez la nouvelle race" style="display: none;"><br>

                <!-- regime alimentaire -->
                <div id="regimeContainer" style="display: none;">
                    <label for="regime">Régime :</label>
                    <select name="regime">
                        <option value="carnivore">Carnivore</option>
                        <option value="herbivore">Herbivore</option>
                        <option value="omnivore">Omnivore</option>
                    </select><br>
                </div>

                <!-- poid -->
                <label for="poid">Poids (kg) :</label>
                <input type="number" step="0.1" name="poid" required><br>

                <!-- nouve habitat  / s affiche si choix 'Autre' sur race  -->
                <div id="habitatContainer" style="display: none;">
                    <label for="habitat">Habitat :</label>
                    <select name="habitat" id="habitatSelect">
                        <option value="">Sélectionnez un habitat</option>
                        <?php foreach ($habitats as $habitat): ?>
                            <option value="<?= htmlspecialchars($habitat['name']) ?>">
                                <?= htmlspecialchars($habitat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="Autre">Autre (ajouter un nouvel habitat)</option>
                    </select>
                    <input type="text" name="newHabitat" id="newHabitatInput" placeholder="Entrez le nouvel habitat" style="display: none;"><br>
                </div>

                <!-- descritption -->
                <label for="description">Description :</label>
                <textarea name="description" required></textarea><br>

                <!-- sex -->
                <label for="sex">Sexe :</label>
                <select name="sex" required>
                    <option value="M">Mâle</option>
                    <option value="F">Femelle</option>
                </select><br>

                <!-- date de naissance -->
                <label for="birthday">Date de naissance :</label>
                <input type="date" name="birthday" id="birthday" max="<?= date('Y-m-d'); ?>" required><br>
                
                <!-- information de santé -->
                <label for="health">Santé :</label>
                <input type="text" name="health" required>
                
                <!-- téléchargement d 'images -->
                <label for="image">Télécharger une plusieurs images (format .webp) :</label>
               <input type="file" name="images[]" accept=".webp" multiple><br>

                <button type="submit">Soumettre</button>
            </form>
        </div>

        <!-- Formulaire de modification d'animal -->
        <div id="modifAnimalForm" >
            <h3>Modifier un animal</h3>
            <form action ="../back/modifAnimal.php" method="POST" enctype="multipart/form-data">
                <!-- selection par nom -->
                <label for="animalSelect">Sélectionner un animal</label>
                <select id="animalSelect" name="animalSelect">
                    <option value="">Sélectionnez un animal</option>
                    <?php foreach ($animals as $animal): ?>
                        <option value="<?= (int)($animal['id']) ?>">
                            <?= htmlspecialchars($animal['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
                <!-- modifier le nom  -->
                <div id = "newNameContainer" style = "display:none;">
                    <label for="newName">Modifier le nom : </label>
                    <input type="text" id="newName" name="newName" placeholder="Entrez le nouveau nom si nécessaire">
                </div>
                <!-- modifier la race / s affiche si le nom à été selectionné -->
                <div id="raceModifContainer" style = "display:none;">
                    <label for="raceModifSelect">modifier la race</label>
                    <select id="raceModifSelect" name="race">
                        <option value="">Sélectionnez une race</option>
                        <?php foreach ($races as $race): ?>
                            <option value="<?= (int)($race['id']) ?>" data-regime="<?= htmlspecialchars($race['regime']) ?>">
                                <?= htmlspecialchars($race['name']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="Autre">Autre (ajouter une nouvelle race)</option>
                    </select><br>
                    <!-- nouvelle race / s affiche si "Autre est selectionné dans race -->
                    <input type="text" id="newRaceModifInput" name="newRace" placeholder="Nouvelle Race" style="display:none;">
                </div><br>

                <!-- modifier le régime  / s affiche si autre à été selectionné dans race-->
                <div id="regimeModifContainer" style="display: none;">
                    <label for="regimeModif">Régime :</label>
                    <select name="regimeModif">
                        <option value="">Selectionnez le régime alimentaire</option>
                        <option value="carnivore">Carnivore</option>
                        <option value="herbivore">Herbivore</option>
                        <option value="omnivore">Omnivore</option>
                    </select><br>
                </div>

                <!-- modifier l' habitat  /s ' affiche si autre à était selectionné dans race -->
                <div id="habitatModifContainer" style="display: none;">
                    <label for="habitatModifSelect">modifier l'habitat</label>
                    <select id="habitatModifSelect" name="habitat">
                    <option value="">Sélectionnez un habitat</option>
                        <?php foreach ($habitats as $habitat): ?>
                            <option value="<?= htmlspecialchars($habitat['name']) ?>">
                                <?= htmlspecialchars($habitat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="Autre">Autre (ajouter un nouvel habitat)</option>
                    </select>
                    <!-- nouvel habitat / s affiche si autre est selectionné dans habitat -->
                    <input type="text" id="newHabitatModifInput" name="newHabitat" placeholder="Nouvel Habitat" style="display:none;">
                </div>

                <!-- modification de la description prè rempli en js / s affiche si le nom à était selectionné  -->
                 <div id="descriptionModifContainer"  style="display: none;">
                    <label for="descriptionModif">Description</label>
                    <textarea id="descriptionModif" name="description" ></textarea>
                 </div>
               
                
                <!-- sex  / s affiche si le nom à était selectionné -->
                <div id="sexModifContainer"  style="display: none;">
                    <label for="sexModif">Modifier le sexe :</label>
                    <select name="sexModif">
                        <option value="">Selectionnez le sexe</option>
                        <option value="M">Mâle</option>
                        <option value="F">Femelle</option>
                    </select><br>
                </div>

                <!-- date de naissance  / s affiche si le nom à était selectionné -->
                <div id="birthdayModifContainer"  style="display: none;">
                    <label for="birthdayModif">Date de naissance :</label>
                    <input type="date" name="birthdayModif" id="birthdayModif" max="<?= date('Y-m-d'); ?>"><br>
                </div>
                
                <!-- information de santé date de naissance  / s affiche si le nom à était selectionné pré rempli en js-->
                <div id="healthModifContainer"  style="display: none;">
                    <label for="healthModif">Santé :</label>
                    <input type="text" name="healthModif">
                </div>

                <!-- checkbox pour supprimer les images / s affiche si le nom à était selectionné pré rempli en js-->
                <div id="imageContainerModif" style = "display :none">
                    <label>Images Actuelles</label>
                    <!-- Images actuelles affichées dynamiquement avec cases à cocher -->
                </div>

                <!-- telechargement de nouvelles images / s affiche si le nom à était selectionné -->
                <div id="newImagesContainer"  style="display: none;">
                    <label for="images">Ajouter de nouvelles images</label>
                    <input type="file" id="images" name="images[]" accept=".webp" multiple>
                    <br>
                </div>

                <button type="submit">Soumettre</button>
            </form>
        </div>

    </main>
    <script src="../js/animals.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succès de l'action) -->
</body>
</html>
