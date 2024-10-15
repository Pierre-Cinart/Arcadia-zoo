document.addEventListener('DOMContentLoaded', function() {
    const addPersonnelBtn = document.getElementById('addPersonnelBtn');
    const addPersonneForm = document.getElementById('addPersonneForm');
    const showPersonnelBtn = document.getElementById('showPersonnelBtn');
    const showPersonne = document.getElementById('showPersonne');

    // Cacher le formulaire et la section d'affichage au départ
    addPersonneForm.style.display = 'none';
    showPersonne.style.display = 'none';

    // Afficher ou cacher le formulaire lors du clic sur le bouton "Ajouter Personnel"
    addPersonnelBtn.addEventListener('click', function() {
        if (addPersonneForm.style.display === 'none') {
            addPersonneForm.style.display = 'block';
            showPersonne.style.display = 'none'; // Cacher la section d'affichage si le formulaire est ouvert
        } else {
            addPersonneForm.style.display = 'none';
        }
    });

    // Afficher ou cacher la section "Afficher le Personnel"
    showPersonnelBtn.addEventListener('click', function() {
        if (showPersonne.style.display === 'none') {
            showPersonne.style.display = 'block';
            addPersonneForm.style.display = 'none'; // Cacher le formulaire si la section d'affichage est ouverte
        } else {
            showPersonne.style.display = 'none';
        }
    });
});
