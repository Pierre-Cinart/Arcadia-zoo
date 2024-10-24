<?php
// utiliser un include en début de page necessitant une pagination pour initialiser les variables
    // Limite affichage par page
    $limit = 5; // items affichés
    $limitBtn = 5; // Boutons de navigation

    // Vérifier si le paramètre 'page' existe dans l'URL est qu il est bien un nombre entier , sinon mettre sur la première page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 0 ? (int)$_GET['page'] : 1;

//verfier si le get['page'] est valid
function verifPage ($page , $totalPage) {
    $page = (int)$page;
    // empecher de dépasser la dernière page
    if ($page > $totalPage) {
        $page = $totalPage;
    }
}
// fonction de pagination 
function paginate($totalPages , $page , $limit , $limitBtn ){

    // Calculer l'offset pour savoir à partir de quel enregistrement commencer
    $offset = ($page - 1) * $limit;
   
    // Générer les liens de pagination
    echo '<div class="pagination" style="text-align:center; margin-top: 20px;">';

    // Bouton page précédente - 5 si existe
    if ($page - 5 >= 1) {
        echo '<a class = "btnPage" href="?page=' . ($page - 5) . '#pagination" class="btn-nav"> << - 5 </a>';
    }

    // Bouton page précédente
    if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '#pagination" class="btn-nav"> << </a>';
    }

    // Calculer le début et la fin des boutons de pagination
    $start = max(1, $page - floor($limitBtn / 2));// pour centrer le bouton de page selectionné
    $end = min($totalPages, $start + $limitBtn - 1);

    // Ajuster le début si on est proche du début
    if ($start < 1) {
        $end = min($totalPages, $end + (1 - $start));
        $start = 1;
    }

    // Ajuster la fin si on est proche de la fin
    if ($end > $totalPages) {
        $start = max(1, $start - ($end - $totalPages));
        $end = $totalPages;
    }

    // Affichage des boutons de page
    for ($i = $start; $i <= $end; $i++) {
        // Mettre en évidence la page actuelle
        if ($i == $page) {
            echo '<a href="#pagination" class="active"><strong>' . $i . '</strong></a> '; // Page active sans lien
        } else {
            echo '<a href="?page=' . $i . '#pagination">' . $i . '</a> '; // Lien vers les autres pages
        }
    }

    // Bouton page suivante
    if ($page < $totalPages) {
        echo '<a href="?page=' . ($page + 1) . '#pagination" class="btn-nav"> >> </a>';
    }

    // Bouton page suivante + 5 

    if ($start + 5 <= $totalPages ) {
        if ($page + 5 > $totalPages) {
            echo '<a class = "btnPage" href="?page=' . ($totalPages) . '#pagination" class="btn-nav"> >> + 5 </a>';
            } else {
                echo '<a class = "btnPage" href="?page=' . ($page + 5) . '#pagination" class="btn-nav"> >> + 5 </a>';
            }
        }
    
        //empecher l accés aux pages inexistantes 
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages#pagination");
        exit();
    }

    echo '</div>'; // Fin du container pagination

}
