<?phpsession_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' ||!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
}

// Connexion à la base de données
include_once '../back/bdd.php';

// pour utilisation de token
include_once '../back/token.php';

checkToken($conn);// verifie si le token de session est correct et le met à jour

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
   
    $id = intval($_GET['id']);
     
    } else {
        $_SESSION['error'] = 'une erreur est survenue ';
        header('Location:../admin/personnel.php');exit();
    }

    // Si aucune erreur, procéder à l'insertion
    if (empty($error_message)) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête SQL pour insérer le compte
        $sql = "SELECT * FROM users  WHERE id = ? ";

        // Préparer et exécuter la requête
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
               // attribuer les valeurs au formulaire
            } else {
                $_SESSION['error'] = "Erreur lors de l accés au  compte : " . $stmt->error; // Enregistrer l'erreur
                // Redirection vers la page de personnel
                header("Location: ../admin/personnel.php");
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Erreur de préparation de la requête : " . $conn->error; // Enregistrer l'erreur
            // Redirection vers la page de personnel
            header("Location: ../admin/personnel.php");
            exit();
        }
    }
   
    // Fermer la connexion
    $conn->close();
    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion commentaires</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <?php include_once "../php/btnBack.php"; ?> <!-- bouton de retour -->
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- navBarr -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    
    <main class="admin">
        <h1 id = "titleAvis">Gestion du personnel</h1>
        <div id="modifPersonneForm">
            <h3>Ajouter un membre</h3>
            <form id="createUser" method="POST" action="../back/createUser.php">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>

                <label for="surname">Prénom :</label>
                <input type="text" id="surname" name="surname" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required autocomplete="off">
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required autocomplete="off">

                <label for="confirmPassword">Confirmer le mot de passe :</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required autocomplete="off">

                <label for="role">Rôle :</label>
                <select id="role" name="role" style="margin-bottom: 15px;" required>
                    <option value="" disabled selected>Sélectionnez un rôle</option>
                    <option value="agent">Agent</option>
                    <option value="veterinaire">Vétérinaire</option>
                </select>
                <br>

                <button type="submit">Soumettre</button>
            </form>

        </div>
        <div id="showPersonne" style = "text-align : center;">
            <?php include_once "../back/showUsers.php"; ?>
        </div>
    </main>
    <?php
        // Fermer la connexion à la base de données
        $conn->close();
    ?>
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succès de l'action) -->
</body>
</html>
