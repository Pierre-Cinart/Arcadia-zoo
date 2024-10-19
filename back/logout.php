<?php
session_start();
session_unset();  // Efface toutes les variables de session

$_SESSION['success'] = 'Votre session est bien déconnectée , merci à bientôt'; // popup
header("Location: ../admin/index.php");  // Redirige vers la page d'accueil
exit();
?>
