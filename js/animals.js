document.addEventListener('DOMContentLoaded', function() {
    const addAnimalBtn = document.getElementById('addAnimalBtn');
    const addAnimalForm = document.getElementById('addAnimalForm');
    const showAnimalsBtn = document.getElementById('showAnimalsBtn');
    const showAnimals = document.getElementById('showAnimals');
    
    // Cacher le formulaire et la section d'affichage au départ
    addAnimalForm.style.display = 'none';
    showAnimals.style.display = 'none';

    // Afficher ou cacher le formulaire lors du clic sur le bouton "Ajouter Animals"
    addAnimalBtn.addEventListener('click', function() {
        addAnimalForm.style.display = 'block';
        showAnimals.style.display = 'none'; // Cacher la section d'affichage si le formulaire est ouvert
    });

    // Afficher ou cacher la section "Afficher le Animals"
    showAnimalsBtn.addEventListener('click', function() {
        showAnimals.style.display = 'block';
        addAnimalForm.style.display = 'none'; // Cacher le formulaire si la section d'affichage est ouverte
    });
});