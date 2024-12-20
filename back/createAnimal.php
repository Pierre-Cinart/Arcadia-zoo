<?php
session_start();

// Vérification du rôle de l'utilisateur
if (!isset($_SESSION['role']) || !isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php');
    exit();
}


include_once './bdd.php';
include_once './token.php';
checkToken($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     // Récupération des données du formulaire
     // recupération des données required 
    $user_id = $_SESSION['user_id'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $sex = htmlspecialchars($_POST['sex']);
    $health = htmlspecialchars($_POST['health']);
    $birthday = htmlspecialchars($_POST['birthday']);
    $poid = htmlspecialchars($_POST['poid']);
    $regime = htmlspecialchars($_POST['regime']); 

    // recupération des données not required et traitement 
    // Gestion de données race
    $race = isset($_POST['race']) ? htmlspecialchars($_POST['race']) : null;
    $newRace = isset($_POST['newRace']) ? htmlspecialchars($_POST['newRace']) : null;

    // Vérification race fermeture si non existante
    if ((empty($race) || $race === "Autre") && empty($newRace)) {
        $_SESSION['error'] = "Vous n'avez renseigné aucune race !!";
        header('Location: ../admin/animaux.php');
        exit();
    }

    // Si selection d une race déjà enregistrée 
    if ($race !== "Autre") {
        // Récupération de l'id de la race
        $sqlRace = "SELECT id FROM races WHERE name = ?";
        $stmtRace = $conn->prepare($sqlRace);
        $stmtRace->bind_param("s", $race);
        $stmtRace->execute();
        $resultRace = $stmtRace->get_result();
        $raceRow = $resultRace->fetch_assoc();
        
        // Vérifier si une race correspondante a été trouvée
        if ($raceRow) {
            $race_id = $raceRow['id'];
        } else {
            $_SESSION['error'] = "Race introuvable dans la base de données.";
            header('Location: ../admin/animaux.php');
            exit();
        }
        $stmtRace->close();

        // Récupération de l'habitat correspondant à cette race
        $sqlHabitat = "SELECT habitat FROM races WHERE id = ?";
        $stmtHabitat = $conn->prepare($sqlHabitat);
        $stmtHabitat->bind_param("i", $race_id);
        $stmtHabitat->execute();
        $resultHabitat = $stmtHabitat->get_result();
        $habitatRow = $resultHabitat->fetch_assoc();
        
        // Assigner l'habitat si trouvé
        if ($habitatRow) {
            $habitat_id = $habitatRow['habitat'];
        } else {
            $_SESSION['error'] = "Habitat introuvable pour cette race.";
            header('Location: ../admin/animaux.php');
            exit();
        }
        $stmtHabitat->close();
    }

    // si une nouvelle Race est renseignée l inscrire en base de données    
    if (!empty($newRace)) {
    //  Vérifier si la race existe déjà dans la table
    $sqlCheck = "SELECT id FROM races WHERE name = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $newRace);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $raceRow = $resultCheck->fetch_assoc();

    if ($raceRow) {
        // La race existe déjà, récupération de l'id existant
        $race_id = $raceRow['id'];
    } else {
        // La race n'existe pas, on l'insère dans la table
        $sqlInsert = "INSERT INTO races (name, regime) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ss", $newRace, $regime);
        
        if ($stmtInsert->execute()) {
            // Récupération de l'id de la race nouvellement insérée
            $race_id = $conn->insert_id;
        } else {
            // En cas d'erreur lors de l'insertion
            $_SESSION['error'] = "Erreur lors de l'insertion de la nouvelle race.";
            header('Location: ../admin/animaux.php');
            exit();
        }
        $stmtInsert->close();
    }
    $stmtCheck->close();
    }

    // Gestion des données habitat
    $habitat = isset($_POST['habitat']) ? htmlspecialchars($_POST['habitat']) : null;
    $newHabitat = isset($_POST['newHabitat']) ? htmlspecialchars($_POST['newHabitat']) : null;
    
    // aucun habitat renseigné // fermeture programme 
    if ((empty($habitat) || $habitat === "Autre") && empty($newHabitat) && !isset($habitat_id)) {
        $_SESSION['error'] = "Vous n'avez renseigné aucun habitat !!";
        header('Location: ../admin/animaux.php');
        exit();
    }

    // nouvel habitat
    if (!empty($newHabitat)) {
         // Insertion des informations de l'habitat dans la base de données
         $title_txt = 'mettre à jour';
         $description = 'mettre à jour';
         $picture = 'mettre à jour';
         $sql = "INSERT INTO habitats (name, title_txt, description,picture , maj_by) VALUES (?, ?, ? , ? , ? )";
         $stmtInsert = $conn->prepare($sql);
         $stmtInsert->bind_param("ssssi", $newHabitat,$title_txt ,$description , $picture ,$user_id);
         // recupération de son id et assignation à $habitat_id 
         if ($stmtInsert->execute()) {
            // Récupération de l'id de la race nouvellement insérée
            $habitat_id = $conn->insert_id;
        } else {
            // En cas d'erreur lors de l'insertion
            $_SESSION['error'] = "Erreur lors de l'insertion du nouvelle habitat.";
            header('Location: ../admin/habitats.php');
            exit();
        }
        $stmtInsert->close();
    }
    

    // Vérification du nom avec regex
    if (!preg_match("/^[a-zA-Z\s-]+$/", $name)) {
        $_SESSION['error'] = "Le nom de l'animal contient des caractères non autorisés.";
        header('Location: ../admin/animaux.php');
        exit();
    }

 // Ajout de l'animal dans la base de données
$sql = "INSERT INTO animals (name, description, sex, health, birthday, poid, race_id, maj_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssdii", $name, $description, $sex, $health, $birthday, $poid, $race_id, $user_id);

if ($stmt->execute()) {
    // Récupération de l'ID de l'animal nouvellement inséré
    $animal_id = $stmt->insert_id; // Ceci devrait donner une valeur
    $stmt->close(); // Fermer le statement après exécution
} else {
    $_SESSION['error'] = "Erreur lors de l'ajout de l'animal.";
    header('Location: ../admin/animaux.php');
    exit();
}

// Gestion des images après l'insertion de l'animal
if (isset($_FILES['images'])) {
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

        if (!move_uploaded_file($tmpName, $uploadFile)) {
            $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
            header('Location: ../admin/animaux.php');
            exit();
        }

        // Insertion de l'image dans la base de données
        $sqlPicture = "INSERT INTO animal_pictures (name, animal_id, maj_by) VALUES (?, ?, ?)";
        $stmtPicture = $conn->prepare($sqlPicture);
        $stmtPicture->bind_param("sii", $pictureName, $animal_id, $user_id); // Utiliser l'animal_id ici

        if (!$stmtPicture->execute()) {
            $_SESSION['error'] = "Erreur lors de l'ajout de l'image de l'animal.";
            // On ne sort pas ici pour continuer à traiter les autres images
        }

        $stmtPicture->close();
    }
    
    $_SESSION['success'] = "Animal ajouté avec succès avec les images !";
    if (isset($_POST['newHabitat']) && $_POST['newHabitat']) {
        $_SESSION['success'] .= " Nouvel habitat ajouté.";
    }
    createNewClickId('race',$race_id) ;
    createNewClickId('animal',$animal_id) ;
} else {
    $_SESSION['error'] = "Aucune image téléchargée.";
}

// Fermer la connexion à la base de données
$conn->close();
header('Location: ../admin/animaux.php');
exit();
}

// Fonction pour ajouter un nouvel ID avec clicks = 0
function createNewClickId($type, $id) {
    // Déterminer le chemin du fichier JSON en fonction du type
    $filePath = '';
    if ($type === 'animal') {
        $filePath = '../data/clic_animal.json';
    } elseif ($type === 'race') {
        $filePath = '../data/clic_race.json';
    } else {
        echo "Type non valide.";
        return;
    }

    // Charger les données JSON existantes
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
    } else {
        // Initialiser un tableau vide si le fichier n'existe pas
        $data = [];
    }

    // Ajouter un nouvel ID avec clicks = 0
    if (!isset($data[$id])) {
        $data[$id] = ['clicks' => 0];
        
        // Enregistrer les données mises à jour dans le fichier JSON
        if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "ID ajouté avec succès dans $filePath.";
        } else {
            echo "Erreur lors de l'écriture dans le fichier $filePath.";
        }
    } else {
        echo "L'ID existe déjà dans $filePath.";
    }
}