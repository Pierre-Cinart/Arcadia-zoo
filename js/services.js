document.addEventListener('DOMContentLoaded', function() {
    const createService = document.getElementById('createService');
    const createServiceBtn = document.getElementById('createServiceBtn');
    const modifService = document.getElementById('modifService');
    // Cacher le formulaire d ajout
    createService.style.display = 'none';
    modifService.style.display = 'none';
    
    // Afficher ou cacher le formulaire lors du clic sur le bouton ajouter
    createServiceBtn.addEventListener('click', function() {
        //cacher le formulaire de modification si il est visible
        if (modifService.style.display === 'block'){
            closeModifService();
           } 
        // afficher ou cacher le formulaire d ajout
        if (createService.style.display === 'block'){
            createService.style.display = 'none';
        } else {
            createService.style.display = 'block';
            }
        
    });
});


function confirmDelete(event, id, name) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    if (confirm("Voulez-vous vraiment supprimer ce service : " + name + " ?")) {
        window.location.href = "../back/deleteService.php?id=" + id;
    }
}

function modif(event, id, name) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    // cacher le formulaire d ajout si il est visible
    if (createService.style.display === 'block'){
        createService.style.display = 'none';
       } 
      
    modifService.style.display = 'block';
    

}

function closeModifService(){
    modifService.style.display = 'none';
}