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
//fermer leformulaire d ajout
function closeModifService(){
    modifService.style.display = 'none';
}
//popup de confirmation avant d effacer 
function confirmDelete(event, id, name) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    if (confirm("Voulez-vous vraiment supprimer ce service : " + name + " ?")) {
        window.location.href = "../back/deleteService.php?id=" + id;
    }
}
   
// afficher le formulaire pré-rempli
function modif(event, id, name , description , picture) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    let modifName = document.getElementById('modifName');
    let modifDescription = document.getElementById('modifDescription');
    let modifPicture = document.getElementById('modifPicture');

    modifName.value = name;
    modifDescription.value = description;
    // modifPicture.value = picture;
   
    
  
    // cacher le formulaire d ajout si il est visible
    if (createService.style.display === 'block'){
        createService.style.display = 'none';
       }   
    modifService.style.display = 'block';  

 
}
// valider les modifications
function confirmModif(id , name , description , picture){

}

