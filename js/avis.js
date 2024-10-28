document.addEventListener('DOMContentLoaded', function() {
    const showUnvalidBtn = document.getElementById('showUnvalidBtn');
    const avisUnValid = document.getElementById('avisUnValid');
    const showValidBtn = document.getElementById('showValidBtn');
    const avisValid = document.getElementById('avisValid');

    // Vérifier l'état du localStorage pour déterminer quelle section afficher
    const currentView = localStorage.getItem('currentView');
    console.log(currentView);
  

    // Afficher la section appropriée
    if (currentView === 'unvalid') {
        avisUnValid.style.display = 'block';
        avisValid.style.display = 'none';
    } else if (currentView === 'valid') {
        avisValid.style.display = 'block';
        avisUnValid.style.display = 'none';
    } else if (currentView === 'none' || currentView === undefined) {
          // Cacher les sections par défaut
        avisUnValid.style.display = 'none';
        avisValid.style.display = 'none';
    } 

    // Afficher les avis en attente
    showUnvalidBtn.addEventListener('click', function() {
        // afficher les avis en attente
        if (currentView === 'none' || currentView === 'valid' || currentView === undefined) {
            localStorage.setItem('currentView', 'unvalid');
            //masquer les avis en attente
        } else if (currentView === 'unvalid') {
            localStorage.setItem('currentView', 'none');;
        }
        
        window.location.href = `avis.php?page=1`; // Reset la pagination
    });

    // Afficher les avis validés
    showValidBtn.addEventListener('click', function() {
         // afficher les avis en attente
         if (currentView === 'none' || currentView === 'unvalid' || currentView === undefined) {
            localStorage.setItem('currentView', 'valid');
            //masquer les avis en attente
        } else if (currentView === 'valid') {
            localStorage.setItem('currentView', 'none');;
        }
        
        window.location.href = `avis.php?page=1`; // Reset la pagination
    });
});

    
// fonction de confirmation de suppression du commentaire
function confirmDelete(id) {
    if (confirm("Voulez-vous vraiment supprimer ce commentaire ?")) {
        window.location.href = "../back/deleteAvis.php?id=" + id;
    }
}
