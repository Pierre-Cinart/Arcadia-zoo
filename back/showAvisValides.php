<?php
// Inclure la connexion à la base de données
include_once '../back/bdd.php';

// Configuration de la pagination
include_once '../php/pagination.php';

// Requête SQL pour compter le nombre total d'avis validés pour la pagination
$sqlCount = "SELECT COUNT(*) AS total FROM avis WHERE isVisible = TRUE";
$resultCount = $conn->query($sqlCount);
$totalAvis = $resultCount->fetch_assoc()['total'];
// verifie si il y a des données vide 
if ($totalAvis == false){
    $totalPages = 1 ;//pour fixer l affichage de la pagination en cas de données null
    $page = 1;
 } else {
     // Calculer le nombre total de pages
     $totalPages = ceil($totalAvis / $limit);
    }

// Vérification de $page
verifPage($page , $totalPages);

// Calculer l'offset pour savoir à partir de quel enregistrement commencer
$offset = ($page - 1) * $limit;

// Requête SQL pour récupérer les avis validés avec LIMIT et OFFSET
$sql = "SELECT id, pseudo, commentaire, created_at FROM avis WHERE isVisible = TRUE ORDER BY created_at DESC LIMIT ? OFFSET ?;";
$stmt = $conn->prepare($sql); // Préparer la requête pour éviter les injections SQL
$stmt->bind_param('ii', $limit, $offset); // Associer les paramètres (limite et offset)
$stmt->execute(); // Exécuter la requête
$result = $stmt->get_result(); // Récupérer le résultat de la requête

// Vérifier si des avis validés ont été trouvés
if ($result->num_rows > 0) {
    echo '<<h2>Commentaires validés</h2>';
    echo '<div class="avis-container">'; // Container pour les avis
    while ($row = $result->fetch_assoc()) {
        // Formater la date au format désiré
        $dateTime = new DateTime($row['created_at']);
        $formattedDate = $dateTime->format('d-m-Y à H:i:s');

        echo '<div class="avis">';
            echo '<h4>' . htmlspecialchars($row['pseudo']) . ' : </h4>'; // Afficher le pseudo
            echo '<p>' . htmlspecialchars($row['commentaire']) . '</p>'; // Afficher le commentaire
            echo '<small>Publié le ' . htmlspecialchars($formattedDate) . '</small><br>'; // Date de publication
            
            // Ajouter l'icône de suppression avec confirmation JavaScript
            echo '<div class="avis-actions">';
                echo '<a href="#" onclick="confirmDelete(' . $row['id'] . ')"><img src="../img/icones/supp.png" alt="Supprimer" title="Supprimer"></a>';
            echo '</div>'; // Fin des actions
        echo '</div>'; // Fin de l'avis
    }
    echo '</div>'; // Fin du container
} else {
    // Afficher un message s'il n'y a aucun avis validé
    echo '<p style="text-align:center; width:100%">Aucun avis validé</p>';
}

// Appeler la fonction paginate pour afficher les boutons de pagination même s'il n'y a aucun résultat
paginate($totalPages, $page, $limit, $limitBtn);

// Fermer la requête préparée
$stmt->close();

// connexion Fermée sur la page concernée car requêtes séparées
?>
