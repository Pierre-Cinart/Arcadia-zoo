// Fonction pour envoyer une requête à l'API et gérer la réponse
function sendRequest(type, id, action, callback) {
    // Vérifie que tous les paramètres sont valides
    if (!type || !id || !action) {
        console.error('Paramètres manquants pour la requête');
        return;
    }

    // Affiche dans la console les informations de la requête
    console.log(`Envoi de la requête: type=${type}, id=${id}, action=${action}`);

    // Création de l'URL pour l'appel API avec les paramètres passés
    const url = `../back/clicks.php?type=${type}&id=${id}&action=${action}`;
    console.log('URL de la requête: ', url);

    // Création de la requête XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    // Fonction appelée lorsque la réponse de l'API est reçue
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText); // Analyse la réponse JSON
            console.log('Réponse de l\'API reçue:', response); // Affiche la réponse de l'API

            if (response.success) {
                // Appel de la fonction callback si la requête est réussie
                console.log(`Action ${action} réussie pour l'ID ${id}`);
                callback(null, response);
            } else {
                // Si l'API a renvoyé une erreur, on passe l'erreur à la callback
                console.error('Erreur API:', response.message);
                callback(response.message, null);
            }
        } else {
            // Si le statut de la requête n'est pas 200 (OK), on signale l'erreur
            console.error(`Erreur lors de l'appel API, statut: ${xhr.status}`);
            callback('Erreur lors de l\'appel API', null);
        }
    };

    // Fonction appelée en cas d'erreur lors de la requête
    xhr.onerror = function() {
        console.error('Erreur de connexion à l\'API');
        callback('Erreur de connexion à l\'API', null);
    };

    // Envoie la requête
    xhr.send();
}

// Fonction pour ajouter un clic
function addClick(type, id) {
    console.log(`Ajout d'un clic pour: type=${type}, id=${id}`);
    sendRequest(type, id, 'add', function(error, response) {
        if (error) {
            console.log('Erreur : ' + error);
        } else {
            console.log(`Clic ajouté ! Total des clics pour l'ID ${id} : ${response.clicks}`);
        }
    });
}

// Fonction pour supprimer un ID
function deleteId(type, id) {
    console.log(`Suppression de l'ID ${id} pour le type ${type}`);
    sendRequest(type, id, 'delete', function(error, response) {
        if (error) {
            console.log('Erreur : ' + error);
        } else {
            console.log(`ID ${id} supprimé avec succès.`);
        }
    });
}
