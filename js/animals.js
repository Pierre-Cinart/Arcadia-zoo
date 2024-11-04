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

    // Récupération des input du formulaire de modification 
    const animalSelect = document.getElementById("animalSelect");
    const newNameContainer = document.getElementById("newNameContainer");
    const raceModifContainer = document.getElementById("raceModifContainer");
    const raceModifSelect = document.getElementById("raceModifSelect");
    const newRaceModifInput = document.getElementById("newRaceModifInput");
    const regimeModifContainer = document.getElementById("regimeModifContainer");
    const habitatModifContainer = document.getElementById("habitatModifContainer");
    const habitatModifSelect = document.getElementById("habitatModifSelect");
    const newHabitatModifInput = document.getElementById("newHabitatModifInput");
    const descriptionModifContainer = document.getElementById("descriptionModifContainer");
    const sexModifContainer = document.getElementById("sexModifContainer");
    const birthdayModifContainer = document.getElementById("birthdayModifContainer");
    const healthModifContainer = document.getElementById("healthModifContainer");
    const imageContainerModif = document.getElementById("imageContainerModif");
    const newImagesContainer = document.getElementById("newImagesContainer");


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

     // Écouteur d'événement pour la sélection de l'animal
     animalSelect.addEventListener("change", function () {
        const selectedAnimal = this.value;
        if (selectedAnimal) {
            newNameContainer.style.display = "block";
            raceModifContainer.style.display = "block";
            descriptionModifContainer.style.display = "block";
            sexModifContainer.style.display = "block";
            birthdayModifContainer.style.display = "block";
            healthModifContainer.style.display = "block";
            imageContainerModif.style.display = "block";
            newImagesContainer.style.display = "block";
    
            // Appel à l'API pour récupérer les images
            fetch(`../back/getAnimalImages.php?animalId=${selectedAnimal}`)
                .then(response => response.json())
                .then(data => { // Renomme `images` en `data` pour mieux représenter les données reçues
                    // Vider le conteneur des images avant d'ajouter les nouvelles
                    imageContainerModif.innerHTML = '<label>Images Actuelles</label>';
    
                    const nameId = data.nameId; // Récupérer le nom de l'animal
                    const images = data.images; // Récupérer les images
    
                    if (images.length > 0) {
                        images.forEach(image => {
                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'imageToDelete[]'; // Nom pour le tableau des images à supprimer
                            checkbox.value = image.name; // Valeur de l'image
    
                            const label = document.createElement('label');
                            label.textContent = '  ' + image.name  // Affiche le nom de l'image
                            label.prepend(checkbox); // Ajoute la case à cocher avant le texte
    
                            // Créer un élément image pour afficher l'image
                            const img = document.createElement('img');
                            img.src = `../img/animaux/${nameId}/${image.name}.webp`; // Définir le chemin de l'image
                            img.alt = image.name; // Texte alternatif pour l'image
                            img.style.width = '100px'; // Largeur de l'image, ajuste selon tes besoins
                            img.style.height = '100px'; // Hauteur automatique pour conserver les proportions
    
                            // Ajouter le label et l'image au conteneur
                            imageContainerModif.appendChild(img); // Ajouter l'image après le label
                            imageContainerModif.appendChild(label);
                            imageContainerModif.appendChild(document.createElement('br')); // Saut de ligne
                        });
                    } else {
                        const noImagesMessage = document.createElement('p');
                        noImagesMessage.textContent = 'Aucune image trouvée pour cet animal.';
                        imageContainerModif.appendChild(noImagesMessage);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des images :', error);
                    imageContainerModif.innerHTML = '<p>Erreur de récupération des images.</p>';
                });
        }
    });
    
    // Écouteur d'événement pour la sélection de la race
    raceModifSelect.addEventListener("change", function () {
        if (this.value === "Autre") {
            newRaceModifInput.style.display = "block"; // Afficher le champ pour une nouvelle race 
            regimeModifContainer.style.display = "block";// Afficher le champ regime
            habitatModifContainer.style.display = "block"; // Afficher le champ pour le nouvel habitat
        } else {
            habitatModifContainer.style.display = "none"; // Masquer le champ si une race est sélectionnée
            regimeModifContainer.style.display = "none";//  Masquer le champ regime
            habitatModifContainer.style.display = "none"; //  Masquer le champ pour le nouvel habitat
        }
    });

    // Écouteur d'événement pour la sélection de l'habitat
    habitatModifSelect.addEventListener("change", function () {
        if (this.value === "Autre") {
            newHabitatModifInput.style.display = "block"; // Afficher le champ pour un nouvel habitat
        } else {
            newHabitatModifInput.style.display = "none"; // Masquer le champ si un habitat est sélectionné
        }
    });
});

