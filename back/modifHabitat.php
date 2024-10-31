<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent')) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité, veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} 

// Connexion à la base de données
include_once('../back/bdd.php');

// Pour utilisation de token
include_once '../back/token.php';

checkToken($conn); // Vérifie si le token de session est correct et le met à jour

// formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
    // traiter  le formulaire
    // enregister les changements

} else if ( ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) ) {
    // remplir le formulaire
}

// Rediriger vers la page de gestion des habitats
// header("Location: ../admin/habitats.php");
// exit();
// ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion personnel</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- navbarr -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    <main class="admin">
        <div id="modifHabitatForm">
            <h3>Modifier les informations d ' un habitat :</h3>
            <form id="createUser" method="POST" action="../back/createUser.php" enctype="multipart/form-data">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>

                <label for="title-txt">En-tête :</label>
                <input type="text" id="title-txt" name="title-txt" required>

                <label for="description">Description :</label>
                <input type="text" id="description" name="description" required>
                
                
                <label for="picture">Image du service : (format autorisé : webp)</label>
                <input type="file" id="picture" name="picture" accept=".webp" required>
                
                <br>
                <button type="submit">Soumettre</button>
            </form>

        </div>
    </main>
    <script src="../js/habitats.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>