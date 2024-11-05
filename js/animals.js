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
    const submitModifForm = document.getElementById("submitModifForm"); // Formulaire de soumission

    // Cacher le formulaire et les sections d'affichage au départ
    addAnimalForm.style.display = 'none';
    modifAnimalForm.style.display = 'none';

    // Afficher le formulaire "Ajouter animal" lors du clic sur le bouton "Ajouter Animal" et cacher les autres sections
    addAnimalBtn.addEventListener('click', function() {
        addAnimalForm.style.display = addAnimalForm.style.display === "block" ? "none" : "block"; 
        modifAnimalForm.style.display = 'none'; 
    });

    // Afficher la section "Affichage des animaux" et cacher les autres sections
    modifAnimalBtn.addEventListener('click', function() {
        modifAnimalForm.style.display = modifAnimalForm.style.display === "block" ? "none" : "block"; 
        addAnimalForm.style.display = 'none'; 
    });

    // Gestion de l'affichage des champs pour le formulaire d'ajout d'animal
    raceSelect.addEventListener("change", function() {
        const selectedOption = raceSelect.options[raceSelect.selectedIndex];
        const regime = selectedOption.getAttribute("data-regime");

        newRaceInput.style.display = raceSelect.value === "Autre" ? "block" : "none";
        regimeContainer.style.display = (raceSelect.value === "Autre" || !regime) ? "block" : "none";
        habitatContainer.style.display = raceSelect.value === "Autre" ? "block" : "none";
    });

    // Gestion de l'affichage des champs pour le nouvel habitat
    habitatSelect.addEventListener("change", function() {
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
                .then(data => {
                    imageContainerModif.innerHTML = '<label>Images Actuelles</label>';
                    const nameId = data.nameId; 
                    const images = data.images; 

                    if (images.length > 0) {
                        images.forEach(image => {
                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'imageToDelete[]'; 
                            checkbox.value = `../img/animaux/${nameId}/${image.name}.webp`; 

                            const label = document.createElement('label');
                            label.textContent = image.name; 
                            label.prepend(checkbox); 

                            const img = document.createElement('img');
                            img.src = `../img/animaux/${nameId}/${image.name}.webp`; 
                            img.alt = image.name; 
                            img.style.width = '100px'; 
                            img.style.height = '100px'; 

                            imageContainerModif.appendChild(img); 
                            imageContainerModif.appendChild(label);
                            imageContainerModif.appendChild(document.createElement('br')); 
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
            newRaceModifInput.style.display = "block"; 
            regimeModifContainer.style.display = "block"; 
            habitatModifContainer.style.display = "block"; 
        } else {
            habitatModifContainer.style.display = "none"; 
            regimeModifContainer.style.display = "none"; 
            habitatModifContainer.style.display = "none"; 
        }
    });

    // Écouteur d'événement pour la sélection de l'habitat
    habitatModifSelect.addEventListener("change", function () {
        if (this.value === "Autre") {
            newHabitatModifInput.style.display = "block"; 
        } else {
            newHabitatModifInput.style.display = "none"; 
        }
    });

    // Écouteur d'événement pour la soumission du formulaire de modification
    submitModifForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut de soumission du formulaire
        const formData = new FormData(this); // Récupère les données du formulaire

        // Envoi des données via fetch ou XMLHttpRequest
        fetch('../back/updateAnimal.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Gérer la réponse ici
            console.log(data);
            // Par exemple, afficher un message de succès ou mettre à jour l'interface
        })
        .catch(error => {
            console.error('Erreur lors de la mise à jour de l\'animal :', error);
        });
    });
});
