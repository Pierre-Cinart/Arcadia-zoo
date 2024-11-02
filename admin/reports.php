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
    <title>Habitats</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>      
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>  <!--navbarr -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
   
    <main class="admin">
         <!--boutons d action -->
    <div style = "display: flex; justify-content: center; gap: 10px;margin:20px;">
            <button id="foodBtn" onclick = "toggleForm(1)">Rapport nourriture</button>
            <button id="healthBtn" onclick = "toggleForm(2)">Rapport santé</button>
    </div>
    <br>
    <!-- formulaire rapport nourriture -->
    <div id="foodReportForm" >
            <form action="../back/report.php" method="POST" >
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
        <!-- formulaire rapport santé -->
        <div id="healthReportForm">
            <form action="../back/report.php" method="POST" >
            <h3>Transmettre les informations sanitaires :</h3>
            <br>
                <label for="name">Animal :</label>
                <select name="name" id="nameSelect" required>
                    <option value="">Sélectionnez un animal</option>
                    <!-- faire une boucle sur les noms  d'animaux -->
                </select>
                <label for="nb">Remarque :</label>
                <input type="textarea" name ="nb" id="nb">
                <label for="weight">Poids (kg) :</label>
                <input type="number" step="0.1" name="weight" required><br>
                <button type="submit">Soumettre</button>
            </form>
        </div>
    </main>
    <script src="../js/reports.js"></script> <!-- affichage du formulaire + confirmation delete -->
    <script src="../js/toggleMenu.js"></script> <!-- Navbar mobile -->
    <script src="../js/popup.js"></script> <!-- Popup pour les messages de succès ou d'erreur -->
</body>
</html>
