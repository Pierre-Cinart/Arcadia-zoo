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
        addPersonneForm.style.display = 'block';
        showPersonne.style.display = 'none'; // Cacher la section d'affichage si le formulaire est ouvert
    });

    // Afficher ou cacher la section "Afficher le Personnel"
    showPersonnelBtn.addEventListener('click', function() {
        showPersonne.style.display = 'block';
        addPersonneForm.style.display = 'none'; // Cacher le formulaire si la section d'affichage est ouverte
    });

    // Événement de soumission du formulaire
    document.getElementById('createUser').addEventListener('submit', function(event) {
        console.log(valider);
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/; // Minimum 8 caractères, 1 majuscule, 1 chiffre, 1 symbole

        let errorMessage = '';

        // Vérification du mot de passe
        if (!passwordPattern.test(password)) {
            errorMessage = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un symbole.';
        } else if (password !== confirmPassword) {
            errorMessage = 'Les mots de passe ne correspondent pas.';
        }

        if (errorMessage) {
            event.preventDefault(); // Empêche l'envoi du formulaire
            // Ajoute le message d'erreur au champ mot de passe
            document.getElementById('password').title = errorMessage;
        } else {
            // Réinitialiser le titre si tout est bon
            document.getElementById('password').title = '';
        }
        console.log(errorMessage);
    });
});
