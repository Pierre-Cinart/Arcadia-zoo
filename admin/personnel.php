<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
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
            <button id="addPersonnelBtn">Ajouter Personnel</button>
            <button id="showPersonnelBtn">Afficher le Personnel</button>
        </div>
        <div id="addPersonneForm">
            <h3>Ajouter un membre</h3>
            <form id="createUser" method="POST" action="../back/createUser.php">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>

                <label for="surname">Prénom :</label>
                <input type="text" id="surname" name="surname" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required autocomplete="off">
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required autocomplete="off">

                <label for="confirmPassword">Confirmer le mot de passe :</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required autocomplete="off">

                <label for="role">Rôle :</label>
                <select id="role" name="role" style="margin-bottom: 15px;" required>
                    <option value="" disabled selected>Sélectionnez un rôle</option>
                    <option value="agent">Agent</option>
                    <option value="veterinaire">Vétérinaire</option>
                </select>
                <br>

                <button type="submit">Soumettre</button>
            </form>

        </div>
        <div id="showPersonne" style = "text-align : center;">
            <?php include_once "../back/showPersonnel.php"; ?>
        </div>
    </main>
    <script src="../js/perso.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>