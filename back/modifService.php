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
include_once('../back/bdd.php');

// Pour utilisation de token
include_once '../back/token.php';

checkToken($conn); // Vérifie si le token de session est correct et le met à jour

// Vérifier si l'ID est bien passé en paramètre
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); 
    $name = nl2br($_POST['name']);
    $description = nl2br($_POST['modifDescription']);
    
    // Préparer la requête pour mettre à jour le service
    $sql = "UPDATE services SET name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $name, $description, $id);
    
    // Exécuter la requête de mise à jour
    if ($stmt->execute()) {
        // Vérifier si une nouvelle image a été téléchargée
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] !== UPLOAD_ERR_NO_FILE) {
            // Si une nouvelle image est téléchargée, récupérer l'ancienne image pour suppression
            $sql = "SELECT picture FROM services WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($oldPicture);
            $stmt->fetch();
            
            // Suppression de l'ancienne image
            if ($oldPicture) {
                $oldImagePath = "../img/services/" . $oldPicture . ".webp"; // Chemin de l'ancienne image
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Supprime l'image
                }
            }
            
            // Traiter la nouvelle image
            $newPictureName = basename($_FILES['picture']['name']);
            $newImagePath = "../img/services/" . $newPictureName;

            // Déplacer la nouvelle image vers le dossier cible
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $newImagePath)) {
                // Mettre à jour le nom de l'image dans la base de données
                $sql = "UPDATE services SET picture = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $newPictureName, $id);
                $stmt->execute();
            } else {
                $_SESSION['error'] = "Erreur lors de l'upload de la nouvelle image.";
            }
        }

        $_SESSION['success'] = "Le service a été modifié avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour du service.";
    }

    $stmt->close();
} else {
    // Rediriger si aucun ID n'est fourni
    $_SESSION['error'] = "Aucun service spécifié pour la modification.";
}

// Fermer la connexion à la base de données
$conn->close();
// Rediriger vers la page de gestion des services
header("Location: ../admin/services.php");
exit();
?>
