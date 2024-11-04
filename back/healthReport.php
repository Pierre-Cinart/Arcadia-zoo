<?php
session_start();

// Vérification du rôle de l'utilisateur et de l'authentification
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent' && $_SESSION['role'] !== 'veterinaire' ) || !isset($_SESSION['user_id'])) {
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
    $animal_name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $report_txt = isset($_POST['remarque']) ? trim($_POST['remarque']) : '';
    $weight = isset($_POST['weight']) ? floatval($_POST['weight']) : null;

    // Vérification des champs
    if (empty($animal_name) || empty($report_txt)) {
        $_SESSION['error'] = "Veuillez sélectionner un animal et entrer une remarque.";
        header("Location: ../admin/reports.php");
        exit();
    }

    // Récupération de l'ID de l'animal
    $animalQuery = $conn->prepare("SELECT id FROM animals WHERE name = ?");
    $animalQuery->bind_param("s", $animal_name);
    $animalQuery->execute();
    $animalResult = $animalQuery->get_result();
    $animal = $animalResult->fetch_assoc();

    if (!$animal) {
        $_SESSION['error'] = "L'animal sélectionné est invalide.";
        header("Location: ../admin/reports.php");
        exit();
    }

    $animal_id = intval($animal['id']);

    // Insertion des données dans la table animal_reports
    $insertQuery = $conn->prepare("INSERT INTO animal_reports (animal_id, report_txt, user_id) VALUES (?, ?, ?)");
    $insertQuery->bind_param("isi", $animal_id, $report_txt, $user_id);

    if ($insertQuery->execute()) {
        $_SESSION['success'] = "Rapport de santé enregistré avec succès.";

        // Mise à jour du poids dans la table animals si le poids est défini
        if ($weight !== null) {
            $updateWeightQuery = $conn->prepare("UPDATE animals SET poid = ? WHERE id = ?");
            $updateWeightQuery->bind_param("di", $weight, $animal_id);
            $updateWeightQuery->execute();
        }
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
?>
