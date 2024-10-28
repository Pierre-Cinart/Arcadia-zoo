<?php
session_start();

function postMsg($url) {
    // Définir un délai de 30 secondes entre chaque soumission
    $delai = 30;

    // Vérifie si une session 'postMsg' existe et calcule le temps écoulé
    if (isset($_SESSION['postMsg'])) {
        $tempsEcoule = time() - $_SESSION['postMsg'];

        if ($tempsEcoule < $delai) {
            // Si le délai n'est pas respecté, message d'erreur et redirection vers la page passée en paramètre
            $_SESSION['error'] = "Trop grand nombre de tentatives. Veuillez réessayer dans quelques instants.";
            header('Location: ' . $url);
            exit();
        } else {
            // Si le délai est respecté, met à jour 'postMsg' avec le timestamp actuel
            $_SESSION['postMsg'] = time();
        }
    } else {
        // Si 'postMsg' n'existe pas encore, on le crée avec le timestamp actuel
        $_SESSION['postMsg'] = time();
    }
}
?>
