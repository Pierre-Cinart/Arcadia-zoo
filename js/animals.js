// Attendre que le DOM soit complètement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Récupération des éléments HTML nécessaires
    const addAnimalBtn = document.getElementById('addAnimalBtn');
    const addAnimalForm = document.getElementById('addAnimalForm');
    const modifAnimalBtn = document.getElementById('modifAnimalBtn');
    const modifAnimalForm = document.getElementById('modifAnimalForm');

    // Récupération des input du formulaire d'ajout d'animal
    const raceSelect = document.getElementById("raceSelect");
    const newRaceInput = document.getElementById("newRaceInput");
    const regimeContainer = document.getElementById("regimeContainer");
    const habitatContainer = document.getElementById("habitatContainer");
    const habitatSelect = document.getElementById("habitatSelect");
    const newHabitatInput = document.getElementById("newHabitatInput");

    // Cacher le formulaire et les sections d'affichage au départ
    addAnimalForm.style.display = 'none';
    modifAnimalForm.style.display = 'none';

    // Afficher le formulaire "Ajouter animal" lors du clic sur le bouton "Ajouter Animal" et cacher les autres sections
    addAnimalBtn.addEventListener('click', function() {
        console.log('click add');
        addAnimalForm.style.display = addAnimalForm.style.display === "block" ? "none" : "block"; 
        modifAnimalForm.style.display = 'none'; 
    });

    // Afficher la section "Affichage des animaux" et cacher les autres sections
    modifAnimalBtn.addEventListener('click', function() {
        console.log('click mod');
        modifAnimalForm.style.display = modifAnimalForm.style.display === "block" ? "none" : "block"; 
        addAnimalForm.style.display = 'none'; 
    });

    // Gestion de l'affichage des champs pour le formulaire d'ajout d'animal
    raceSelect.addEventListener("change", function() {
        // Récupération de l'option sélectionnée et de son régime
        const selectedOption = raceSelect.options[raceSelect.selectedIndex];
        const regime = selectedOption.getAttribute("data-regime");

        // Affiche le champ pour ajouter une nouvelle race si "Autre" est sélectionné
        newRaceInput.style.display = raceSelect.value === "Autre" ? "block" : "none";
        
        // Affiche le régime si "Autre" est sélectionné ou si la race n’a pas de régime prédéfini
        regimeContainer.style.display = (raceSelect.value === "Autre" || !regime) ? "block" : "none";

        // Affiche .le conteneur d'habitat si la race est "Autre"
        habitatContainer.style.display = raceSelect.value === "Autre" ? "block" : "none";
    });

    // Gestion de l'affichage des champs pour le nouvel habitat
    habitatSelect.addEventListener("change", function() {
        // Affiche le champ pour ajouter un nouvel habitat si "Autre" est sélectionné
        newHabitatInput.style.display = habitatSelect.value === "Autre" ? "block" : "none";
    });
});
