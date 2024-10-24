<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' 
|| $_SESSION['role'] !== 'agent' )){
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité , veuillez vous reconnecter.";
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
    <title>Gestion commentaires</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- navBarr -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    
    <main class="admin">
        <h1 id = "titleAvis">Gestion des commentaires</h1>
        <div style = "display: flex; justify-content: center; gap: 10px;margin:20px;">
            <button id="showUnvalidBtn">Avis en attente :</button>
            <button id="showValidBtn">Avis validés :</button>
        </div>
        
        <div id="avisUnValid">
            <?php include_once '../back/showAvisEnAttente.php'; ?>
        </div>

        <div id="avisValid">
            <?php include_once '../back/showAvisValides.php'; ?>
        </div>
    </main>
    <?php
        // Fermer la connexion à la base de données
        $conn->close();
    ?>
    <script src="../js/avis.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succès de l'action) -->
</body>
</html>
