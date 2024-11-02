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
    if (empty($_POST['choice'])) {
        $_SESSION['error'] = 'Erreur de choix';
        header('Location: ../admin/reports.php');
        $conn->close();
        exit();
    } else {
        $choice = $_POST['choice'];}
        
} else {
    $_SESSION['error'] = 'Erreur de méthode';
    header('Location: ../admin/reports.php');
    $conn->close();
    exit();
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
    <?php include_once "../php/btnBack.php"; ?>  <!-- bouton de retour -->    
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>  <!-- Navbar -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->
   
    <main class="admin">
        <div>
            <?php echo back('../admin/reports', "r");  // Lien de retour 
            switch ($choice) {
                //rapport de nouriture
                case 'food': {
                    if (empty($_POST['race'])) {
                        $_SESSION['error'] = 'Erreur de choix';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit(); 
                    } else {
                        $race = $_POST['race'];
                    }   
                    echo '<h3>' . $name . '</h3>';
                    echo  ''/* quantité de nourriture recu : $quantity*/; 
                    echo  ''/* par : $user_id */; 
                } 
                break;
                //rapport de santé  
                case 'health': {
                    if (empty($_POST['name'])) {
                        $_SESSION['error'] = 'Erreur de choix';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit(); ;
                    } else {
                        $name = $_POST['name'];
                    }    
                } 
                break;
                // rapport détaillé complet 
                case 'full':{
                    if (empty($_POST['name'])) {
                        $_SESSION['error'] = 'Erreur de choix';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit(); 
                    } else {
                        $name = $_POST['name'];
                    } 
                }
                break; 
                    
                default:
                    $_SESSION['error'] = 'Choix nul ou invalide';
                    header('Location: ../admin/reports.php');
                    $conn->close();
                    exit();
            }
        
             $conn->close(); ?>
        </div>
    </main>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/popup.js"></script>
    <?php  $conn->close(); ?> <!-- fermeture de connexion bdd -->
</body>

</html>
