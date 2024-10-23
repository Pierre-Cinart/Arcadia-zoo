
document.addEventListener('DOMContentLoaded', function() {
    const showUnvalidBtn = document.getElementById('showUnvalidBtn');
    const avisUnValid = document.getElementById('avisUnValid');
    const showValidBtn = document.getElementById('showValidBtn');
    const avisValid = document.getElementById('avisValid');
    
    // Cacher le formulaire et la section d'affichage au départ
    avisUnValid.style.display = 'none';
    avisValid.style.display = 'none';

    // Afficher ou cacher le formulaire lors du clic sur le bouton "Ajouter Personnel"
    showUnvalidBtn.addEventListener('click', function() {
        avisUnValid.style.display = 'block';
        avisValid.style.display = 'none'; // Cacher la section d'affichage si le formulaire est ouvert
    });

    // Afficher ou cacher la section "Afficher le Personnel"
    showValidBtn.addEventListener('click', function() {
        avisValid.style.display = 'block';
        avisUnValid.style.display = 'none'; // Cacher le formulaire si la section d'affichage est ouverte
    });

});
