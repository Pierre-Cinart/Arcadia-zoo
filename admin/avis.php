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
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    
    <main class="admin">
        <h1>Gestion des commentaires</h1>

        <h2>Avis en attente :</h2>
        <div id="avis-en-attente">
            <?php include_once '../back/showAvisEnAttente.php'; ?>
        </div>

        <h2 class="green">Avis validés :</h2>
        <div id="avis-valides">
            <?php include_once '../back/showAvisValides.php'; ?>
        </div>
    </main>
    <?php
        // Fermer la connexion à la base de données
        $conn->close();
    ?>

    

    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succès de l'action) -->
</body>
</html>
