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

// Récupérer les noms des animaux
$animalsQuery = "SELECT id, name FROM animals";
$animalsResult = $conn->query($animalsQuery);
if ($animalsResult) {
    $animals = $animalsResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Gérer l'erreur si la requête échoue
    $animals = [];
    error_log("Erreur lors de la récupération des animaux : " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>      
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>  <!-- Navbar -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->
   
    <main class="admin">
        <!-- Boutons d'action -->
        <div style="display: flex; justify-content: center; gap: 10px; margin: 20px;">
            <button id="foodBtn" onclick="toggleForm(1)">Rapport nourriture</button>
            <button id="healthBtn" onclick="toggleForm(2)">Rapport santé</button>
            <button id="ReportsBtn" onclick="toggleForm(3)">Consulter les rapports</button>
        </div>
        <br>
        <!-- Formulaire rapport nourriture -->
        <div id="foodReportForm">
            <form action="../back/report.php" method="POST">
                <h3>Transmettre les informations de nourriture :</h3>
                <br>
                <label for="race">Race :</label>
                <select name="race" id="raceSelect" required>
                    <option value="">Sélectionnez une race</option>
                    <?php foreach ($races as $race): ?>
                        <option value="<?= htmlspecialchars($race['name']) ?>" data-regime="<?= htmlspecialchars($race['regime']) ?>">
                            <?= htmlspecialchars($race['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="quantity">Poids (kg) :</label>
                <input type="number" step="0.1" name="quantity" required><br>
                <button type="submit">Soumettre</button>
            </form>
        </div>
        <!-- Formulaire rapport santé -->
        <div id="healthReportForm">
            <form action="../back/report.php" method="POST">
                <h3>Transmettre les informations sanitaires :</h3>
                <br>
                <label for="name">Animal :</label>
                <select name="name" id="nameSelect" required>
                    <option value="">Sélectionnez un animal</option>
                    <?php foreach ($animals as $animal): ?>
                        <option value="<?= htmlspecialchars($animal['name']) ?>">
                            <?= htmlspecialchars($animal['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="remarque">Remarque :</label>
                <textarea name="remarque" id="remarque" rows="4" cols="50" placeholder="Entrez votre remarque ici"></textarea>

                <label for="weight">Poids (kg) :</label>
                <input type="number" step="0.1" name="weight" required><br>

                <button type="submit">Soumettre</button>
            </form>
        </div>
        <div id="reports">
            <h3>consulter les rapports : </h3>
            <h3>rapport de nourriture : </h3>
            <!-- rapport santé -->
            <div id="foodReports">
                <div id="foodReportSelect">
                    <!-- ajouter un select race -->
                </div>
                <div id="showFoodReports">
                    <!-- afficher la dernière nouriture donnée et la date selon la race selectionnée -->
                </div>
            </div>
            <!-- rapport santé -->
            <h3>rapport santé :</h3>
            <div id="healthReports">
                <div id="HealthReportSelect">
                    <!-- ajouter un select name -->
                </div>
                <div id="showHealthReports">
                    <!-- afficher le nouriture donnée et la date selon la race selectionnée -->
                </div> 
            </div>
           <!-- Rapport complet  -->
            <h3>rapport complet</h3>
            <div id="fullReports">
                <p>selectionnez l animal :</p>
                <!-- ajouter un select animal -->
                <p>afficher les dates à consulter </p>
                de :
                <!-- ajouter un select date -->
                à :
                <!-- ajouter un select date -->

             <div id="showFullReport" ?>>
              <!-- afficher les rapports selectionné -->
             </div>
            </div>
            
        </div>
    </main>
    <script src="../js/reports.js"></script> <!-- Affichage du formulaire + confirmation delete -->
    <script src="../js/toggleMenu.js"></script> <!-- Navbar mobile -->
    <script src="../js/popup.js"></script> <!-- Popup pour les messages de succès ou d'erreur -->
</body>
</html>
