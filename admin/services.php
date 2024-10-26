<?php
session_start();

// Vérification du rôle (admin ou agent)
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent')) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis pour des raisons de sécurité, veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else {
    $role = $_SESSION['role'];
    // Connexion à la base de données
    include_once '../back/bdd.php'; // Inclusion de la connexion
    // pour utilisation de token
    include_once '../back/token.php';
    checkToken($conn); // Vérifie si le token de session est correct et le met à jour
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des services</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- Barre de navigation -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->

    <main class="admin">
        <h1>Gestion des services</h1>
        <div style="display: flex; justify-content: center; gap: 10px; margin: 20px;">
            <button id="createServiceBtn">Ajouter un service</button> <!-- Bouton pour ajouter un service -->
        </div>
        
        <!-- formulaire ajout de service -->
        <form id="createService" method="POST" action="../back/createService.php" enctype="multipart/form-data">
            <h3>Ajouter un service</h3>
            <label for="name">Nom du service :</label>
            <input type="text" id="name" name="name" required>
            
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" required></textarea>
            
            <label for="picture">Image du service : (format autorisé : webp)</label>
            <input type="file" id="picture" name="picture" accept=".webp" required>
            
            <button type="submit">Soumettre</button>
        </form>

        <!-- formulaire de modification de service en sticky -->
        <div id="modifService" style= "position: sticky; top: 25%; , left:50%">
            <form method="POST" action="../back/modifService.php" enctype="multipart/form-data" style ="position :relative;">
                <!-- bouton de fermeture -->
                <button type="button" onclick="closeModifService()" style="position:absolute; top:0; right: 2px; background-color:red;">&times;</button>
                <h3>Modifier le service</h3>
                <!-- Champ caché pour l'ID du service -->
                <input type="hidden" id="modifId" name="id" required>
                <label for="modifName">Nom du service :</label>
                <input type="text" id="modifName" name="name" required>
                
                <label for="modifDescription">Description :</label>
                <textarea id="modifDescription" name="modifDescription" rows="4" required></textarea>
                
                <label for="modifPicture">Image du service : (format autorisé : webp)</label>
                <input type="file" id="modifPicture" name="picture" accept=".webp"> <!-- non obligatoire si vide garde l image enregistrée en bdd -->
                
                <button type="submit">Soumettre</button>
            </form>
        </div>

        <!-- Affichage des services  -->
        <section class="services">
            <?php
            // Préparation de la requête pour récupérer les services
            $sql = "SELECT id, name, description, picture FROM services";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Boucle pour afficher chaque service
                while ($row = $result->fetch_assoc()) {
                    // Récupération des données du service
                    $id = intval($row['id']);
                    $name = htmlspecialchars($row['name']);
                    $description = htmlspecialchars($row['description']);
                    $picture = htmlspecialchars($row['picture']);
                    $imagePath = "../img/services/" . $picture . ".webp"; // Chemin de l'image

                    // Affichage du service
                    echo "<div class='service'>";
                        echo "<h3>$name</h3>";
                        echo "<img src='$imagePath' alt='$name'>";
                        echo "<p>$description</p>";
                        echo '<p style="font-weight:small"> - - - - - - - - - - </p>';
                        // bouton de modification 
                        echo '<a href="#" onclick="modif(event, ' . $id . ', \'' . addslashes(htmlspecialchars($name)) . '\', 
                        \'' . addslashes(htmlspecialchars($description)) . '\', \'' . addslashes(htmlspecialchars($picture)) . '\')">
                                <img src="../img/icones/modif.png" style="width:32px;height:32px;margin-right:25px;" 
                                alt="Modifier" title="Modifier">
                            </a>';
                        // bouton de suppression 
                        echo '<a href="#" onclick="confirmDelete(event, ' . $id . ', \'' . addslashes(htmlspecialchars($name)) . '\')" 
                                class="deleteService">
                                <img src="../img/icones/supp.png" style="width:32px;height:32px;" 
                                alt="Supprimer" title="Supprimer">
                            </a>';
                    echo "</div>";
                }
            } else {
                echo "<p>Aucun service disponible pour le moment.</p>";
            }
            ?>
        </section>
    </main>

    <?php
        // Fermeture de la connexion à la base de données
        $conn->close();
    ?>
    <script src="../js/services.js"></script> <!-- affichage du formulaire + confirmation delete -->
    <script src="../js/toggleMenu.js"></script> <!-- Navbar mobile -->
    <script src="../js/popup.js"></script> <!-- Popup pour les messages de succès ou d'erreur -->
</body>
</html>
