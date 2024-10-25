function confirmDelete(event, id, name) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    if (confirm("Voulez-vous vraiment supprimer ce service : " + name + " ?")) {
        window.location.href = "../back/deleteService.php?id=" + id;
    }
}