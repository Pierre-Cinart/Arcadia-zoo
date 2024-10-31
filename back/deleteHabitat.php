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
include_once ('../back/bdd.php');

// Pour utilisation de token
include_once '../back/token.php';

checkToken($conn); // Vérifie si le token de session est correct et le met à jour

// Vérifier si l'ID est bien passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    // Préparer la requête pour récupérer le nom de l'image
    $sql = "SELECT picture FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    
    // Exécuter la requête
    if ($stmt->execute()) {
        $stmt->bind_result($picture);
        $stmt->fetch();

        // Si une image a été trouvée, essayer de la supprimer
        if ($picture) {
            $imagePath = "../img/habitats/" . $picture . ".webp"; // Chemin de l'image

            // Vérifier si l'image existe et la supprimer
            if (file_exists($imagePath)) {
                unlink($imagePath); // Supprime l'image
            }
        }
    }
    
    // Fermer le statement après avoir récupéré le nom de l'image
    $stmt->close();

    // Préparer la requête de suppression
    $sql = "DELETE FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    
    // Exécuter la requête de suppression
    if ($stmt->execute()) {
        $_SESSION['success'] = "Le habitat a été supprimé avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression de l ' habitat.";
    }

    $stmt->close();
} else {
    // Rediriger si aucun ID n'est fourni
    $_SESSION['error'] = "Aucun habitat spécifié pour la suppression.";
}

// Fermer la connexion à la base de données
$conn->close();
// Rediriger vers la page de gestion des habitats
header("Location: ../admin/habitats.php");
exit();
?>
