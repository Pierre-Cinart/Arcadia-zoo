<?php
session_start();

// Vérification des droits d'accès
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent')) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis. Pour des raisons de sécurité, veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
}

// Connexion à la base de données
include_once('../back/bdd.php');
include_once '../back/token.php';

// Vérifie si le token de session est valide
checkToken($conn); 

// Traitement du formulaire si soumis en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = htmlspecialchars(trim($_POST['name']));
    $title_txt = htmlspecialchars(trim($_POST['title-txt']));
    $description = htmlspecialchars(trim($_POST['description']));
    $maj_by = $_SESSION['user_id']; // Utilisation de user_id de la session

    // Préparation de la requête SQL pour mettre à jour les informations de l'habitat
    $sql = "UPDATE habitats SET name = ?, title_txt = ?, description = ?, maj_by = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssii', $name, $title_txt, $description, $maj_by, $id);

    if ($stmt->execute()) {
        // Vérifie si une image a été uploadée
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            // Récupère l'ancienne image pour la suppression
            $sql = "SELECT picture FROM habitats WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($oldPicture);
            $stmt->fetch();
            $stmt->close();

            if ($oldPicture) {
                $oldImagePath = "../img/habitats/" . $oldPicture;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Supprime l'ancienne image
                }
            }

            // Gère la nouvelle image
            $newPictureName = pathinfo($_FILES['picture']['name'], PATHINFO_FILENAME) . '.webp';
            $newImagePath = "../img/habitats/" . $newPictureName;

            if (move_uploaded_file($_FILES['picture']['tmp_name'], $newImagePath)) {
                // Mise à jour du nom de l'image dans la base de données
                $sql = "UPDATE habitats SET picture = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $newPictureName, $id);
                $stmt->execute();
            } else {
                $_SESSION['error'] = "Erreur lors de l'upload de la nouvelle image.";
            }
        }

        $_SESSION['success'] = "L'habitat a été modifié avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de l'habitat.";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../admin/habitats.php"); // Redirection vers la page de gestion des habitats
    exit();
}

// Récupération des données pour autocompléter le formulaire en GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT name, title_txt, description, picture FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($name, $title_txt, $description, $picture);
    $stmt->fetch();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Habitat</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- Navbar -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->
    <main class="admin">
        <div id="modifHabitatForm">
            <h3>Modifier les informations d'un habitat :</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>

                <label for="title-txt">En-tête :</label>
                <input type="text" id="title-txt" name="title-txt" value="<?= htmlspecialchars($title_txt) ?>" required>

                <label for="description">Description :</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($description) ?></textarea>

                <?php if (isset($picture) && !empty($picture)){
                    echo '<br><p>Image actuelle : <br> <img src="../img/habitats/' . htmlspecialchars($picture) . '.webp" alt="Image actuelle" width="100"></p>';
        }?>

                <label for="picture">Image de l'habitat : (format autorisé : webp)</label>
                <input type="file" id="picture" name="picture" accept=".webp">
              

                <button type="submit">Soumettre</button>
            </form>
        </div>
    </main>
    <script src="../js/habitats.js"></script> <!-- Script pour affichage au clic -->
    <script src="../js/toggleMenu.js"></script> <!-- Navbar mobile -->
    <script src="../js/popup.js"></script> <!-- Popup (erreur ou succès de l'action) -->
</body>
</html>
