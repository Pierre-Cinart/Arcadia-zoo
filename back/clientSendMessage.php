<?php
session_start();
include_once './bdd.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nettoyage des inputs pour éviter les injections de scripts
    $name = htmlspecialchars(trim($_POST['name']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $objet = htmlspecialchars(trim($_POST['objet']));
    $message = htmlspecialchars(trim($_POST['message']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Stocker les valeurs dans $_SESSION pour les réutiliser en cas d'erreur
    $_SESSION['form_data'] = [
        'name' => $name,
        'surname' => $surname,
        'objet' => $objet,
        'message' => $message,
        'email' => $email
    ];

    // Validation des données
    if (empty($name) || empty($surname) || empty($objet) || empty($message) || empty($email)) {
        $_SESSION['error'] = "Tous les champs doivent être remplis.";
        header('Location: ../front/contact.php');
        exit();
    }

    // Vérification que le nom, prénom et objet contiennent au moins 3 lettres non espacées
    if (strlen(str_replace(' ', '', $name)) < 3 || !preg_match('/^[a-zA-Z\s-]+$/', $name)) {
        $_SESSION['error'] = "Le nom doit contenir au moins 3 lettres et peut inclure seulement des lettres, des espaces, et le tiret (-).";
        header('Location: ../front/contact.php');
        exit();
    }

    if (strlen(str_replace(' ', '', $surname)) < 3 || !preg_match('/^[a-zA-Z\s-]+$/', $surname)) {
        $_SESSION['error'] = "Le prénom doit contenir au moins 3 lettres et peut inclure seulement des lettres, des espaces, et le tiret (-).";
        header('Location: ../front/contact.php');
        exit();
    }

    if (strlen(str_replace(' ', '', $objet)) < 3 || !preg_match('/^[a-zA-Z\s-]+$/', $objet)) {
        $_SESSION['error'] = "L'objet doit contenir au moins 3 lettres et peut inclure seulement des lettres, des espaces, et le tiret (-).";
        header('Location: ../front/contact.php');
        exit();
    }

    // Vérification de la longueur minimale du message (par exemple 20 caractères)
    if (strlen($message) < 20) {
        $_SESSION['error'] = "Le message doit contenir au moins 20 caractères.";
        header('Location: ../front/contact.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Adresse e-mail invalide.";
        header('Location: ../front/contact.php');
        exit();
    }

    // Préparation de la requête SQL avec MySQLi
    $stmt = $conn->prepare("INSERT INTO messages (name, surname, object, message, created_at) VALUES (?, ?, ?, ?, NOW())");

    // Liaison des valeurs
    $stmt->bind_param('ssss', $name, $surname, $objet, $message);

    // Exécution de la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = "Votre message a bien été envoyé.";
        unset($_SESSION['form_data']); // Supprimer les données du formulaire après succès
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'envoi de votre message.";
    }

    // Redirection vers la page de contact
    header('Location: ../front/contact.php');
    exit();
} else {
    // Si la requête n'est pas POST, redirection
    $_SESSION['error'] = "Méthode de requête invalide.";
    header('Location: ../front/contact.php');
    exit();
}
