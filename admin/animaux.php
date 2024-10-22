<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' 
|| $_SESSION['role'] !== 'agent' 
|| $_SESSION['role'] !== 'veterinaire')) {

    $_SESSION['error'] = 'La page que vous avez demandé requiert des droits administrateur.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
}
?>

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
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    <main class="admin">
        <div style = "display: flex; justify-content: center; gap: 10px;margin:20px;">
            <button id="addAnimalBtn">Ajouter Un Animal</button>
            <button id="showAnimalsBtn">Consulter Les Animaux</button>
        </div>
        <div id="addAnimalForm">
            <h3>Ajouter un animal</h3>
            <form action="">
                <br>
                <button type="submit">Soumettre</button>
            </form>

        </div>
        <div id="showAnimals" style = "text-align : center;">
            <?php include_once "../back/showAnimals.php"; ?>
        </div>
    </main>
    <script src="../js/animals.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>