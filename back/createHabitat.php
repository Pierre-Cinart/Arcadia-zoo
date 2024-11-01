<?php
    session_start();

    // Vérification du rôle de l'utilisateur et de l'authentification
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent') || !isset($_SESSION['user_id'])) {
        $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur ou agent pour accéder à cette page.';
        header('Location: ../admin/index.php'); // Redirection vers la page de connexion si rôle invalide
        exit();
    }

    // Connexion à la base de données
    include_once './bdd.php';

    // Vérification et mise à jour du token utilisateur
    include_once './token.php';
    checkToken($conn); // Fonction pour vérifier et mettre à jour le token de session

    // Vérifiez si le formulaire a été soumis avec la méthode POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
        // Récupération et sécurisation des données du formulaire
        $user_id = $_SESSION['user_id'];
        $name = htmlspecialchars(trim($_POST['name'])); // Nom de l'habitat
        $titleTxt = htmlspecialchars(trim($_POST['title-txt'])); // Titre de l'habitat
        $description = htmlspecialchars(trim($_POST['description'])); // Description

        // Définir le dossier de téléchargement pour l'image
        $uploadDir = '../img/habitats/';
        $pictureName = $name; // Nom de l'image basé sur le nom de l'habitat
        $uploadFile = $uploadDir . $pictureName . '.webp';

        // Gérer les doublons de nom en ajoutant un compteur si nécessaire
        $counter = 1;
        while (file_exists($uploadFile)) {
            $pictureName = $name . "($counter)";
            $uploadFile = $uploadDir . $pictureName . '.webp';
            $counter++;
        }

        // Déplacement du fichier téléchargé vers le dossier des images
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) {
            $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
            header('Location: ../admin/gestionServices.php');
            exit();
        }

        // Insertion des informations de l'habitat dans la base de données
        $sql = "INSERT INTO habitats (name, title_txt, description, picture, maj_by) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $titleTxt, $description, $pictureName, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Habitat ajouté avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de l'ajout de l'habitat dans la base de données.";
        }

        // Redirection vers la page des habitats après traitement
        header("Location: ../admin/habitats.php");
        exit();
    } else {
        // Erreur si la requête n'est pas de type POST
        $_SESSION['error'] = "Méthode de requête non valide.";
        header("Location: ../admin/habitats.php"); // Redirection vers la page de formulaire
        exit();
    }
?>
