document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prévenir l'envoi du formulaire pour le moment

    // Récupérer les valeurs des champs
    const title = document.getElementById("objet").value;
    const message = document.getElementById("message").value; // Changement ici
    const email = document.getElementById("email").value;

    // Vérifier que tous les champs sont remplis
    if (title && message && email) {
        // Vérification de l'email avec une expression régulière
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Veuillez entrer une adresse e-mail valide.");
            return;
        }

        alert("Merci ! Votre demande a bien été envoyée.");
    } else {
        alert("Veuillez remplir tous les champs avant d'envoyer.");
    }
});
