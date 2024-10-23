document.addEventListener('DOMContentLoaded', function() {
    const showUnvalidBtn = document.getElementById('showUnvalidBtn');
    const avisUnValid = document.getElementById('avisUnValid');
    const showValidBtn = document.getElementById('showValidBtn');
    const avisValid = document.getElementById('avisValid');

    // Vérifier l'état du localStorage pour déterminer quelle section afficher
    const currentView = localStorage.getItem('currentView');

    // Cacher les sections par défaut
    avisUnValid.style.display = 'none';
    avisValid.style.display = 'none';

    // Afficher la section appropriée
    if (currentView === 'unvalid') {
        avisUnValid.style.display = 'block';
    } else if (currentView === 'valid') {
        avisValid.style.display = 'block';
    }

    // Afficher les avis en attente
    showUnvalidBtn.addEventListener('click', function() {
        localStorage.setItem('currentView', 'unvalid'); // Sauvegarder l'état
        window.location.href = `avis.php?page=1`; // Reset la pagination
    });

    // Afficher les avis validés
    showValidBtn.addEventListener('click', function() {
        localStorage.setItem('currentView', 'valid'); // Sauvegarder l'état
        window.location.href = `avis.php?page=1`; // Reset la pagination
    });
});
