<?php
session_start();
include_once '../back/bdd.php'; // Connexion à la base de données

// Vérifier si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $name = htmlspecialchars($_POST['name']);
    $commentaire = htmlspecialchars(trim($_POST['avis']));

    // Validation du nom (au moins 3 lettres, chiffres et le caractère '-' autorisés)
    if (!preg_match('/^[a-zA-Z0-9-]{3,}$/', $name)) {
        $_SESSION['error'] = "Le nom doit contenir au moins 3 lettres sans espace. Les chiffres et le caractère '-' sont autorisés.";
        header("Location: ../front/avis.php");
        exit();
    }

    // Validation du commentaire (au moins 10 caractères)
    if (strlen($commentaire) < 10) {
        $_SESSION['error'] = "Votre avis doit contenir au moins 10 caractères.";
        header("Location: ../front/avis.php");
        exit();
    }

        // Requête SQL pour insérer l'avis
        $sql = "INSERT INTO avis (pseudo, commentaire, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $name, $commentaire);

        // Exécution de la requête
        if ($stmt->execute()) {
            $_SESSION['success'] = "Votre avis a été soumis avec succès et est en attente de validation.";
        } else {
            $_SESSION['error'] = "Erreur lors de la soumission de votre avis. Veuillez réessayer.";
        }

        $stmt->close();
} else {
       $_SESSION['error'] = "une erreur est survenue . Veuillez réessayer";
    }


// Redirection vers la page des avis après traitement
header("Location: ../front/avis.php");
exit();
?>
