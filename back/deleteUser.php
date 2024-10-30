<?php
session_start();

// Vérifier le rôle (assurez-vous que seul l'admin peut supprimer des utilisateurs)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'Accès refusé. Vous devez être administrateur pour effectuer cette action.';
    header('Location: ../admin/index.php');
    exit();
}

// Connexion à la base de données
include_once '../back/bdd.php';

// Vérifier si l'ID est passé en paramètre GET
if (isset($_GET['id'])) {
    // Récupérer l'ID et le sécuriser
    $id = intval($_GET['id']);

    // Préparer la requête pour supprimer l'utilisateur
    $sql = "DELETE FROM users WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        // Exécuter la requête et vérifier le succès
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) { // Vérifier si une ligne a été supprimée
                $_SESSION['success'] = 'L\'utilisateur a été supprimé avec succès.';
            } else {
                $_SESSION['error'] = 'Aucun utilisateur trouvé avec cet ID.';
            }
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur : " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Erreur de préparation de la requête : " . $conn->error;
    }
} else {
    $_SESSION['error'] = 'ID utilisateur non fourni.';
}

// Rediriger vers la page de liste du personnel
header('Location: ../admin/personnel.php');
exit();
session_start();

// Vérifier le rôle (assurez-vous que seul l'admin peut supprimer des utilisateurs)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'Accès refusé. Vous devez être administrateur pour effectuer cette action.';
    header('Location: ../admin/index.php');
    exit();
}

// Connexion à la base de données
include_once '../back/bdd.php';

// Vérifier si l'ID est passé en paramètre GET
if (isset($_GET['id'])) {
    // Récupérer l'ID et le sécuriser
    $id = intval($_GET['id']);

    // Préparer la requête pour supprimer l'utilisateur
    $sql = "DELETE FROM users WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        // Exécuter la requête et vérifier le succès
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) { // Vérifier si une ligne a été supprimée
                $_SESSION['success'] = 'L\'utilisateur a été supprimé avec succès.';
            } else {
                $_SESSION['error'] = 'Aucun utilisateur trouvé avec cet ID.';
            }
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur : " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Erreur de préparation de la requête : " . $conn->error;
    }
} else {
    $_SESSION['error'] = 'ID utilisateur non fourni.';
}

// Rediriger vers la page de liste du personnel
header('Location: ../admin/personnel.php');
exit();

$conn->close();

?>