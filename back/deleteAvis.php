<?php
// Inclure la connexion à la base de données
include_once 'bdd.php';

// Vérifier si l'ID est bien passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID

    // Préparer la requête de suppression
    $sql = "DELETE FROM avis WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Rediriger vers la page des avis avec un message de succès
        $_SESSION['success'] = "Le commentaire a été supprimé avec succès.";
    } else {
        // En cas d'échec, rediriger avec un message d'erreur
        $_SESSION['error'] = "Erreur lors de la suppression du commentaire.";
    }

    $stmt->close();
} else {
    // Rediriger si aucun ID n'est fourni
    $_SESSION['error'] = "Aucun commentaire spécifié pour la suppression.";
}

// Fermer la connexion à la base de données
$conn->close();
// Rediriger vers la page de gestion des avis
header("Location: ../admin/avis.php");

exit();
?>
