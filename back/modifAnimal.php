<?php
session_start();

// Vérification du rôle de l'utilisateur
if (!isset($_SESSION['role']) || !isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent')) {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
    exit();
}

// Connexion à la BDD
include_once './bdd.php';
// Vérification du token
include_once './token.php';
checkToken($conn);

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération user_id
    $user_id = $_SESSION['user_id'];
    // Récupérer l'ID de l'animal sélectionné
    $animal_id = !empty($_POST['animalSelect']) ? (int)$_POST['animalSelect'] : null;
    if ($animal_id === null) {
        $_SESSION['error'] = "Aucun animal sélectionné.";
        $conn->close();
        header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
        exit();
    }

    //supression  des images
    if (isset($_POST['imageToDelete'])) {
        // Récupérer les chemins complets des images à supprimer
        $imagesToDelete = $_POST['imageToDelete'];
    
        // Définir le chemin du dossier de l'animal basé sur le premier chemin d'image
        $animalFolder = dirname($imagesToDelete[0]); 
    
        foreach ($imagesToDelete as $imagePath) {
            // Supprime le fichier du dossier en utilisant le chemin complet
            if (file_exists($imagePath)) {
                unlink($imagePath);
                // L'image a été supprimée, pas d'echo ici mais tu pourrais utiliser une session pour notifier
            } 
    
            // Extraire le nom de l'image sans le chemin ni l'extension
            $imageName = pathinfo($imagePath, PATHINFO_FILENAME);
    
            // Supprimer l'entrée de la base de données en utilisant le nom de l'image et l'ID de l'animal
            $sqlDeletePicture = "DELETE FROM animal_pictures WHERE name = ? AND animal_id = ?";
            $stmtDeletePicture = $conn->prepare($sqlDeletePicture);
            $stmtDeletePicture->bind_param("si", $imageName, $animal_id);
            if ($stmtDeletePicture->execute()) {
                // Entrée supprimée de la base de données, pas d'echo ici mais tu peux aussi notifier
            } 
            $stmtDeletePicture->close();
        }
    
        // Vérifier si le dossier est vide après suppression des images
        if (is_dir($animalFolder) && count(scandir($animalFolder)) == 2) { // `scandir` retourne . et ..
            // Supprimer le dossier
            if (rmdir($animalFolder)) {
                // Dossier supprimé, aucun echo mais tu peux aussi notifier
            } 
        } 
    }
      // Récupérer les données de l'animal
      $sqlAnimal = "SELECT * FROM animals WHERE id = ?";
      $stmtAnimal = $conn->prepare($sqlAnimal);
      $stmtAnimal->bind_param("i", $animal_id);
      $stmtAnimal->execute();
      $animalData = $stmtAnimal->get_result()->fetch_assoc();

    // Gestion des images après l'insertion de l'animal
    if (isset($_FILES['images']) && $_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE)  {
    $name = $animalData['name'];
   
    // Vérifier si plusieurs images sont téléchargées
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "Erreur lors du téléchargement de l'image : " . $_FILES['images']['error'][$key];
            header('Location: ../admin/animaux.php');
            exit();
        }

        $fileType = mime_content_type($tmpName);
        if ($fileType !== 'image/webp') {
            $_SESSION['error'] = "Le format de l'image doit être .webp.";
            header('Location: ../admin/animaux.php');
            exit();
        }

        // Déplacement de l'image avec gestion des doublons de nom
        $uploadDir = '../img/animaux/' . $name . '/'; // Nouveau dossier de destination
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

        // Déplacer le fichier téléchargé vers le nouveau chemin
        if (move_uploaded_file($tmpName, $uploadFile)) {
            // Insertion de l'image dans la base de données
            $sqlPicture = "INSERT INTO animal_pictures (name, animal_id, maj_by) VALUES (?, ?, ?)";
            $stmtPicture = $conn->prepare($sqlPicture);
            $stmtPicture->bind_param("sii", $pictureName, $animal_id, $user_id); // Utiliser l'animal_id ici

            if (!$stmtPicture->execute()) {
                echo "Erreur lors de l'ajout de l'image de l'animal.";
                // On ne sort pas ici pour continuer à traiter les autres images
            } 

            $stmtPicture->close();
        } 
        
        
    }
}


    if (!$animalData) {
        $_SESSION['error'] = "Animal non trouvé.";
        $conn->close();
        header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
        exit();
    }

    // Récupérer les données du formulaire
    $newName = !empty($_POST['newName']) ? $_POST['newName'] : $animalData['name'];
    $race = !empty($_POST['race']) ? (int)$_POST['race'] : $animalData['race_id'];
    $newRace = !empty($_POST['newRace']) ? $_POST['newRace'] : null;
    $habitat = isset($_POST['habitat']) ? $_POST['habitat'] : null;
    $newHabitat = !empty($_POST['newHabitat']) ? $_POST['newHabitat'] : null;
    $regime = isset($_POST['regime']) ? $_POST['regime'] : null;
    $description = !empty($_POST['description']) ? $_POST['description'] : $animalData['description'];
    $sex = !empty($_POST['sexModif']) ? $_POST['sexModif'] : $animalData['sex'];
    $birthday = !empty($_POST['birthdayModif']) ? $_POST['birthdayModif'] : $animalData['birthday'];
    $health = !empty($_POST['healthModif']) ? $_POST['healthModif'] : $animalData['health'];

    // Traitement de la race et habitat et régime
    if ($race === "") {
        $race = $animalData['race_id'];
        // Récupérer les données de la race
        $sqlRace = "SELECT * FROM races WHERE id = ?";
        $stmtRace = $conn->prepare($sqlRace);
        $stmtRace->bind_param("i", $race);
        $stmtRace->execute();
        $raceData = $stmtRace->get_result()->fetch_assoc();
        $regime = $raceData['regime'];
        $habitat = $raceData['habitat'];
        $stmtRace->close();
    } elseif ($race === "Autre") {
        if ($newRace !== null) {
            // Vérification de la validité de la nouvelle race avec Regex
            if (preg_match('/^[a-zA-Z\s]+$/', $newRace)) {
                $race_name = $newRace;
            } else {
                $_SESSION['error'] = "La nouvelle race ne peut contenir que des lettres et des espaces.";
                $conn->close();
                header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
                exit();
            }

            // Vérification de l'habitat
            if ($habitat == "Autre" && $newHabitat !== null) {
                // Vérification nouvel habitat avec Regex
                if (preg_match('/^[a-zA-Z\s]+$/', $newHabitat)) {
                    $habitat = $newHabitat;
                    $title_txt = "";
                    $description = "";
                    $picture = "";
                    // créer l'habitat
                    $sqlUpdateHabitat = "INSERT INTO habitats (name, title_txt, description, picture, maj_by) VALUES (?, ?, ?, ?, ?)";
                    $stmtUpdateHabitat = $conn->prepare($sqlUpdateHabitat);
                    $stmtUpdateHabitat->bind_param("ssssi", $habitat, $title_txt, $description, $picture, $user_id);
                    if ($stmtUpdateHabitat->execute()) {
                        $stmtUpdateHabitat->close();
                    } else {
                        $_SESSION['error'] = "Erreur lors de la création de l'habitat.";
                        $conn->close();
                        header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
                        exit();
                    }
                } else {
                    $_SESSION['error'] = "Le nouvel habitat ne peut contenir que des lettres et des espaces.";
                    $conn->close();
                    header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
                    exit();
                }
            }
            if ($newHabitat === null) {
                $firstRace = $animalData['race_id'];
                $sqlRace = "SELECT * FROM races WHERE id = ?";
                $stmtRace = $conn->prepare($sqlRace);
                $stmtRace->bind_param("i", $firstRace);
                $stmtRace->execute();
                $raceData = $stmtRace->get_result()->fetch_assoc();
                $habitat = $raceData['habitat'];
                $stmtRace->close();
            }
            // Vérification du régime
            if ($regime === null) {
                $firstRace = $animalData['race_id'];
                $sqlRace = "SELECT * FROM races WHERE id = ?";
                $stmtRace = $conn->prepare($sqlRace);
                $stmtRace->bind_param("i", $firstRace);
                $stmtRace->execute();
                $raceData = $stmtRace->get_result()->fetch_assoc();
                $regime = $raceData['regime'];
                $stmtRace->close();
            }
        }

        if ($race === $newRace) {
            // Mise à jour de la race
            $sqlUpdateRace = "INSERT INTO races (name, habitat, regime, maj_by) VALUES (?, ?, ?, ?)";
            $stmtUpdateRace = $conn->prepare($sqlUpdateRace);
            $stmtUpdateRace->bind_param("ssii", $race, $habitat, $regime, $user_id);

            if (!$stmtUpdateRace->execute()) {
                $_SESSION['error'] = "Erreur lors de la mise à jour de la race.";
                $stmtUpdateRace->close();
                $conn->close();
                header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
                exit();
            } else {
                // Récupérer l'ID de la dernière race insérée
                $race_id = $conn->insert_id; // Récupère l'ID de la dernière insertion
                $stmtUpdateRace->close();
            }
        }
    }

    // Mise à jour de l'animal
    $sqlUpdateAnimal = "UPDATE animals SET name = ?, race_id = ?, description = ?, sex = ?, birthday = ?, health = ?, maj_by = ? WHERE id = ?";
    $stmtUpdateAnimal = $conn->prepare($sqlUpdateAnimal);
    $stmtUpdateAnimal->bind_param("sissssii", $newName, $race, $description, $sex, $birthday, $health, $user_id, $animal_id);
    
    if ($stmtUpdateAnimal->execute()) {
        $_SESSION['success'] = "Animal mis à jour avec succès.";
        header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de l'animal : " . $stmtUpdateAnimal->error;
        header('Location: ../admin/animaux.php'); // Redirigez vers une page appropriée
    }
    
    $stmtUpdateAnimal->close();
    $conn->close();
    exit();
}
?>
