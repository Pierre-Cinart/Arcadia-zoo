document.addEventListener('DOMContentLoaded', function() {
    const addAnimalBtn = document.getElementById('addAnimalBtn');
    const addAnimalForm = document.getElementById('addAnimalForm');
    const showAnimals = document.getElementById('showAnimals');

    // Fonction pour mettre à jour l'affichage selon l'état du localStorage
    function updateDisplay() {
        const currentView = localStorage.getItem('currentView');

        if (currentView === 'addAnimal') {
            addAnimalForm.style.display = 'block';
            showAnimals.style.display = 'none';
        } else if (currentView === 'showAnimals') {
            showAnimals.style.display = 'block';
            addAnimalForm.style.display = 'none';
        } else {
            // Masquer les deux sections par défaut
            addAnimalForm.style.display = 'none';
            showAnimals.style.display = 'none';
        }
    }

    // Appel initial pour mettre à jour l'affichage
    updateDisplay();

    // Gérer l'affichage du formulaire d'ajout d'animal
    addAnimalBtn.addEventListener('click', function() {
        const currentView = localStorage.getItem('currentView');

        if (currentView !== 'addAnimal') {
            localStorage.setItem('currentView', 'addAnimal');
            addAnimalForm.style.display = 'block';
            showAnimals.style.display = 'none';
        } else {
            localStorage.setItem('currentView', 'none');
            addAnimalForm.style.display = 'none';
        }
    });

    // Gérer l'affichage de la liste des animaux
    const showAnimalsBtn = document.getElementById('showAnimalsBtn'); // Assurez-vous que ce bouton existe
    if (showAnimalsBtn) {
        showAnimalsBtn.addEventListener('click', function() {
            localStorage.setItem('currentView', 'showAnimals');
            addAnimalForm.style.display = 'none';
            showAnimals.style.display = 'block';
        });
    }
});
