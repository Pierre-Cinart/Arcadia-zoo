<?php
session_start();

// Vérification du rôle de l'utilisateur
if (!isset($_SESSION['role']) || !isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
include_once './bdd.php';
include_once './token.php';
checkToken($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $sex = htmlspecialchars($_POST['sex']); 
    $health = htmlspecialchars($_POST['health']); 
    $birthday = htmlspecialchars($_POST['birthday']);
    $poid = htmlspecialchars($_POST['poid']);
    
    // Utilisation de l'ID de la race au lieu de son nom pour le chemin
    if (isset($_POST['newRace'])) {
        $race_id = htmlspecialchars($_POST['newRace']); 
    } else {
        $race_id = htmlspecialchars($_POST['race']); 
    }

    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "Erreur lors du téléchargement de l'image : " . $_FILES['image']['error'];
            header('Location: ../admin/animaux.php');
            exit();
        }

        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        if ($fileType !== 'image/webp') {
            $_SESSION['error'] = "Le format de l'image doit être .webp.";
            header('Location: ../admin/animaux.php');
            exit();
        }

        // Vérification du nom avec regex
        if (!preg_match("/^[a-zA-Z\s-]+$/", $name)) {
            $_SESSION['error'] = "Le nom de l'animal contient des caractères non autorisés.";
            header('Location: ../admin/animaux.php');
            exit();
        }

        // Déplacement de l'image avec gestion des doublons de nom
        $uploadDir = '../img/animaux/' . $race_id . '/' . $name . '/'; // Nouveau dossier de destination
        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Création du dossier avec permissions
        }

        $pictureName = $name; // Nom de l'image sans extension
        $uploadFile = $uploadDir . $pictureName . '.webp';

        // Gestion des doublons
        $counter = 1;
        while (file_exists($uploadFile)) {
            $pictureName = $name . "($counter)";
            $uploadFile = $uploadDir . $pictureName . '.webp';
            $counter++;
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
            header('Location: ../admin/animaux.php');
            exit();
        }

        // Insertion dans la base de données
        $sql = "INSERT INTO animals (name, description, sex, health, birthday, poid, maj_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssdi", $name, $description, $sex, $health, $birthday, $poid,  $user_id);

        if ($stmt->execute()) {
            $animal_id = $stmt->insert_id;
            $sqlPicture = "INSERT INTO animal_pictures (name, animal_id) VALUES (?, ?)";
            $stmtPicture = $conn->prepare($sqlPicture);
            $stmtPicture->bind_param("si", $pictureName, $animal_id);

            if ($stmtPicture->execute()) {
                $_SESSION['success'] = "Animal ajouté avec succès !";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'image de l'animal dans la base de données.";
            }
            $stmtPicture->close();
        } else {
            $_SESSION['error'] = "Erreur lors de l'ajout de l'animal dans la base de données.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Aucune image téléchargée ou image invalide.";
    }

    header('Location: ../admin/animaux.php');
    exit();
}
