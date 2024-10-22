document.addEventListener('DOMContentLoaded', function() {
    const addAnimalBtn = document.getElementById('addAnimalBtn');
    const addAnimalForm = document.getElementById('addAnimalForm');
    const showAnimalsBtn = document.getElementById('showAnimalsBtn');
    const showHabitats = document.getElementById('showHabitats');
    const showHabitatsBtn = document.getElementById('showHabitatsBtn');
    const showAnimals = document.getElementById('showAnimals');
    
    // Cacher le formulaire et les sections d'affichage au départ
    showHabitats.style.display = 'none';
    addAnimalForm.style.display = 'none';
    showAnimals.style.display = 'none';

    // Afficher le formulaire "Ajouter animal" lors du clic sur le bouton "Ajouter Animals" et cacher les autres sections
    addAnimalBtn.addEventListener('click', function() {
        addAnimalForm.style.display = 'block';
        showHabitats.style.display = 'none';
        showAnimals.style.display = 'none'; 
    });

    // Afficher  la section "Affichage des animaux" et cacher les autres sections
    showAnimalsBtn.addEventListener('click', function() {
        showAnimals.style.display = 'block';
        showHabitats.style.display = 'none';
        addAnimalForm.style.display = 'none'; 
    });

     // Afficher  la section "Gestion des habitats" et cacher les autres sections
     showHabitatsBtn.addEventListener('click', function() {
        showAnimals.style.display = 'none';
        showHabitats.style.display = 'block';
        addAnimalForm.style.display = 'none'; 
    });
});