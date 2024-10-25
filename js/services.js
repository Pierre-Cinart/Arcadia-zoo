document.addEventListener('DOMContentLoaded', function() {
    const createService = document.getElementById('createService');
    const createServiceBtn = document.getElementById('createServiceBtn');
    
    // Cacher le formulaire d ajout
    createService.style.display = 'none';
    
    console.log(createService, createServiceBtn); // Vérification
    // Afficher ou cacher le formulaire lors du clic sur le bouton ajouter
    createServiceBtn.addEventListener('click', function() {
       if (createService.style.display === 'block'){
        createService.style.display = 'none';
       } else {
        createService.style.display = 'block';
        }
        
    });
});


function confirmDelete(event, id, name) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    if (confirm("Voulez-vous vraiment supprimer ce service : " + name + " ?")) {
        window.location.href = "../back/deleteService.php?id=" + id;
    }
}