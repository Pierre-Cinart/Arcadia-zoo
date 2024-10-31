// fonction de confirmation de suppression du commentaire
function confirmDelete(event, id) {
    event.preventDefault(); 
    if (confirm("Voulez-vous vraiment supprimer cet habitat ?")) {
        window.location.href = "../back/delehabitat.php?id=" + id;
    }
}