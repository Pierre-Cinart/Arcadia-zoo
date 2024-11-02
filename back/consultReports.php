<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'agent' && $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'veterinaire') || 
    !isset($_SESSION['user_id'])) {
    
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else {
    $id = $_SESSION['user_id'];
    // Connexion à la base de données
    include_once './bdd.php';

    // Pour l'utilisation du token
    include_once './token.php';

    checkToken($conn); // Vérifie si le token de session est correct et le met à jour
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement des données POST (si nécessaire)
} else {
   
    $_SESSION['error'] = 'Erreur de méthode';
    header('Location: ../admin/reports.php');
    $conn->close();
    exit();
}

$conn->close();

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
    <?php include_once "../php/btnBack.php"; ?>  <!-- bouton de retour -->    
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>  <!-- Navbar -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->
   
    <main class="admin">
        <?php echo back('../admin/reports', "r"); ?>  <!-- Lien de retour -->
    </main>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/popup.js"></script>
</body>
</html>
