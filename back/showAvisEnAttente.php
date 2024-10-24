<?php
// Inclure la connexion à la base de données
include_once '../back/bdd.php';

// Configuration de la pagination
include_once '../php/pagination.php'; // Inclure la configuration de pagination si elle est dans un fichier séparé

// Requête SQL pour compter le nombre total d'avis en attente pour calculer le nombre de pages
$sqlCount = "SELECT COUNT(*) AS total FROM avis WHERE isVisible = FALSE";
$resultCount = $conn->query($sqlCount);
$totalAvis = $resultCount->fetch_assoc()['total'];

// definit la page à un pour la pagination en cas de données vide 
if ($totalAvis == false){
    var_dump($resultCount);
   $totalPagesW = 1 ;
   $pageW = 1;
} else {
    // Calculer le nombre total de pages
    $pageW = $page;
    $totalPagesW = ceil($totalAvis / $limit);}

// verification de $pageW
verifPage($pageW , $totalPagesW);

// Calculer l'offset pour savoir à partir de quel enregistrement commencer
$offset = ($pageW - 1) * $limit;

// Requête SQL pour récupérer les avis en attente (LIMIT et OFFSET)
$sql = "SELECT id, pseudo, commentaire, created_at FROM avis WHERE isVisible = FALSE LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql); // Préparer la requête pour éviter les injections SQL
$stmt->bind_param('ii', $limit, $offset); // Associer les paramètres à la requête (limite et offset)
$stmt->execute(); // Exécuter la requête
$result = $stmt->get_result(); // Récupérer le résultat de la requête

// Vérifier si des avis en attente ont été trouvés
if ($result->num_rows > 0) {
    echo '<div class="avis-container">'; // Container pour les avis
    while ($row = $result->fetch_assoc()) {
        // Formater la date au format désiré
        $dateTime = new DateTime($row['created_at']);
        $formattedDate = $dateTime->format('d-m-Y à H:i:s');
        
        echo '<div class="avis">';
        echo '<h4>' . htmlspecialchars($row['pseudo']) . ' : </h4>'; // Afficher le pseudo
        echo '<p>' . htmlspecialchars($row['commentaire']) . '</p>'; // Afficher le commentaire
        echo '<small>Publié le ' . htmlspecialchars($formattedDate) . '</small><br>'; // Date de publication
        
        // Ajouter les icônes pour valider et supprimer
        echo '<div class="avis-actions">';
        echo '<a href="../back/validateAvis.php?id=' . $row['id'] . '"><img src="../img/icones/valid.png" alt="Valider" title="Valider"></a>';
        echo '<a href="../back/deleteAvis.php?id=' . $row['id'] . '"><img src="../img/icones/supp.png" alt="Supprimer" title="Supprimer"></a>';
        echo '</div>'; // Fin des actions
        echo '</div>'; // Fin de l'avis
    }
    echo '</div>'; // Fin du container
} else {
    echo '<p style="text-align:center; width:100%">Aucun avis en attente</p>'; // Message si aucun avis en attente
}

// Fermer la requête préparée
$stmt->close();

// Lancer la fonction de pagination avec $totalPagesW et la page actuelle
paginate($totalPagesW, $pageW, $limit, $limitBtn);

// connexion Fermée sur la page concernée car requêtes séparées

?>
