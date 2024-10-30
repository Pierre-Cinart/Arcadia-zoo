<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin')) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité , veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
    // Connexion à la base de données
    include_once '../back/bdd.php';
    // pour utilisation de token
    include_once '../back/token.php';
     checkToken($conn);// verifie si le token de session est correct et le met à jour
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
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
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

                <label for="firstname">Prénom :</label>
                <input type="text" id="firstname" name="firstname" required>

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
            <?php include_once "../back/showUsers.php"; ?>
        </div>
    </main>
    <script src="../js/perso.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>