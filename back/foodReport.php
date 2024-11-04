<?php
    session_start();

    // Vérification du rôle de l'utilisateur et de l'authentification
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent') || !isset($_SESSION['user_id'])) {
        $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur ou agent pour accéder à cette page.';
        header('Location: ../admin/index.php'); // Redirection vers la page de connexion si rôle invalide
        exit();
    }
    $user_id = intval($_SESSION["user_id"]);
    // Connexion à la base de données
    include_once './bdd.php';

    // Vérification et mise à jour du token utilisateur
    include_once './token.php';
    checkToken($conn); // Fonction pour vérifier et mettre à jour le token de session
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $race_name = isset($_POST['race']) ? trim($_POST['race']) : '';
        $quantity = isset($_POST['quantity']) ? floatval($_POST['quantity']) : 0;
    
        // Vérification de la quantité et de la race
        if (empty($race_name) || $quantity <= 0) {
            $_SESSION['error'] = "Veuillez entrer une race valide et une quantité de nourriture supérieure à 0.";
            header("Location: ../admin/reports.php");
            exit();
        }
    
        // Récupération de l'ID de la race
        $raceQuery = $conn->prepare("SELECT id FROM races WHERE name = ?");
        $raceQuery->bind_param("s", $race_name);
        $raceQuery->execute();
        $raceResult = $raceQuery->get_result();
        $race = $raceResult->fetch_assoc();
        
        if (!$race) {
            $_SESSION['error'] = "La race sélectionnée est invalide.";
            header("Location: ../admin/reports.php");
            exit();
        }
        
        $race_id = intval($race['id']);
    
        // Insertion des données dans la table food_reports
        $insertQuery = $conn->prepare("INSERT INTO food_reports (race_id, quantity, user_id) VALUES (?, ?, ?)");
        $insertQuery->bind_param("idi", $race_id, $quantity, $user_id);
    
        if ($insertQuery->execute()) {
            $_SESSION['success'] = "Rapport de nourriture enregistré avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'enregistrement du rapport : " . $conn->error;
        }
    
        // Redirection vers la page des rapports
        header("Location: ../admin/reports.php");
        exit();
    } else {
        // Erreur si la requête n'est pas de type POST
        $_SESSION['error'] = "Méthode de requête non valide.";
        header("Location: ../admin/reports.php"); // Redirection vers la page de formulaire
        exit();
    }