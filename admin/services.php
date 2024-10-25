<?php
session_start();

// Vérification du rôle (admin ou agent)
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent')) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité, veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else {
    $role = $_SESSION['role'];
     // Connexion à la base de données
     include_once './bdd.php';
     // pour utilisation de token
     include_once './token.php';
     checkToken($conn);// verifie si le token de session est correct et le met à jour
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
            <button id="createService">Ajouter un service</button> <!-- Bouton pour ajouter un service -->
        </div>
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
                    echo '<a href="../back/ModifService.php?id=' . $id . '" id=""><img src="../img/icones/modif.png" style="width:32px;height:32px;margin-right:25px;" alt="Modifier" title="Modifier"></a>';
                    echo '<a href="#" onclick="confirmDelete(event, ' . $id . ', \'' . addslashes($name) . '\')" id=""><img src="../img/icones/supp.png" style="width:32px;height:32px;" alt="Supprimer" title="Supprimer"></a>';
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