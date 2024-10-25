<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' 
|| $_SESSION['role'] !== 'agent' )){
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité , veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} 

// connexion à la base de données
include_once ('../back/bdd.php');

// pour utilisation de token
include_once '../back/token.php';

checkToken($conn);// verifie si le token de session est  et le met à jour

// Vérifier si l'ID est bien passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    // Préparer la requête de suppression
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Rediriger vers la page des avis avec un message de succès
        $_SESSION['success'] = "Le service a été supprimé avec succès.";
    } else {
        // En cas d'échec, rediriger avec un message d'erreur
        $_SESSION['error'] = "Erreur lors de la suppression du commentaire.";
    }

    $stmt->close();
} else {
    // Rediriger si aucun ID n'est fourni
    $_SESSION['error'] = "Aucun service spécifié pour la suppression.";
}

// Fermer la connexion à la base de données
$conn->close();
// Rediriger vers la page de gestion des avis
header("Location: ../admin/services.php");
exit();
?>
