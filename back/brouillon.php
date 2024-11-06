<button onclick="createNewClickId('animal', '123')">Créer ID</button>
<button onclick="addClick('animal', '123')">Ajouter un clic</button>
<button onclick="deleteId('animal', '123')">Supprimer ID</button>

<div id="result"></div>

<script>
function createNewClickId(type, id) {
    fetch(`../back/clicks.php?action=create&type=${type}&id=${id}`)
        .then(response => response.json())
        .then(data => displayResult(data))
        .catch(error => console.error("Erreur:", error));
}

function addClicksk(type, id) {
    fetch(`../back/clicks.php?action=add&type=${type}&id=${id}`)
        .then(response => response.json())
        .then(data => displayResult(data))
        .catch(error => console.error("Erreur:", error));
}

function deleteId(type, id) {
    fetch(`../back/clicks.php?action=delete&type=${type}&id=${id}`)
        .then(response => response.json())
        .then(data => displayResult(data))
        .catch(error => console.error("Erreur:", error));
}

function displayResult(data) {
    const resultDiv = document.getElementById("result");
    if (data.success) {
        resultDiv.innerText = data.message || `Nombre de clics: ${data.clicks}`;
    } else {
        resultDiv.innerText = `Erreur: ${data.message}`;
    }
}
</script>
