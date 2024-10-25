<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
}
// Vérification de l id et assignation à user_id
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
}

// Connexion à la base de données
include_once './bdd.php';

// pour utilisation de token
include_once './token.php';

checkToken($conn);// verifie si le token de session est correct et le met à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et sécurisation des champs
    $name = htmlspecialchars(($_POST['name']));
    $description = htmlspecialchars(($_POST['description']));
    
    // Vérification de l'image
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $fileType = mime_content_type($_FILES['picture']['tmp_name']);

        // Vérification du format de l'image (webp)
        if ($fileType !== 'image/webp') {
            $_SESSION['error'] = "Le format de l'image doit être .webp.";
            header('Location: ../admin/services.php');
            exit();
        }

        // Vérification du nom avec regex
        if (!preg_match("/^[a-zA-Z\s-]+$/", $name)) {
            $_SESSION['error'] = "Le nom du service contient des caractères non autorisés.";
            header('Location: ../admin/services.php');
            exit();
        }

        // Déplacement de l'image avec gestion des doublons de nom
        $uploadDir = '../img/services/';
        $pictureName = $name ;
        $uploadFile = $uploadDir . $pictureName . '.webp';

        $counter = 1;
        while (file_exists($uploadFile)) {
            $pictureName = $name . "($counter)";
            $uploadFile = $uploadDir . $pictureName . '.webp';
            $counter++;
        }

        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) {
            $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
            header('Location: ../admin/gestionServices.php');
            exit();
        }

        // Insertion dans la base de données
        $sql = "INSERT INTO services (name, description, picture) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $description, $pictureName);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Service ajouté avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de l'ajout du service dans la base de données.";
        }

        $stmt->close();

    } else {
        $_SESSION['error'] = "Aucune image téléchargée ou image invalide.";
    }
    
    // Redirection avec les messages de succès ou d’erreur
    header('Location: ../admin/services.php');
    exit();
}
?>
