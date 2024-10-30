<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' || !isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php');
    exit();
}

// Connexion à la base de données
include_once '../back/bdd.php';

// Pour utilisation de token
include_once '../back/token.php';
checkToken($conn);

// Déclaration des variables pour le formulaire
$name = "";
$surname = "";
$email = "";
$role = "";

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérification de la correspondance des mots de passe
    if (!empty($password)) {
        
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            $_SESSION['error'] = "Le mot de passe doit contenir au moins une majuscule, un chiffre, un symbole et être composé d'au moins 8 caractères.";
            header("Location: ../admin/modifUser.php?id=".$id);
            exit();
        }
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
            header("Location: ../admin/modifUser.php?id=".$id);
            exit();
        }
        
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête SQL pour mettre à jour les informations de l'utilisateur, y compris le mot de passe
        $updateSql = "UPDATE users SET name = ?, first_name = ?, email = ?, role = ?, password = ? WHERE id = ?";
        if ($stmt = $conn->prepare($updateSql)) {
            $stmt->bind_param("sssssi", $name, $surname, $email, $role, $hashedPassword, $id);
        }
    } else {
        // Requête SQL sans mise à jour du mot de passe
        $updateSql = "UPDATE users SET name = ?, first_name = ?, email = ?, role = ? WHERE id = ?";
        if ($stmt = $conn->prepare($updateSql)) {
            $stmt->bind_param("ssssi", $name, $surname, $email, $role, $id);
        }
    }

    // Exécution de la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Les informations ont été mises à jour avec succès.';
        header('Location: ../admin/personnel.php');
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour : " . $stmt->error;
        header("Location: ../admin/personnel.php");
        exit();
    }
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Requête SQL pour récupérer les informations de l'utilisateur
    $sql = "SELECT name, first_name AS surname, email, role FROM users WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = htmlspecialchars($row['name']);
                $surname = htmlspecialchars($row['surname']);
                $email = htmlspecialchars($row['email']);
                $role = htmlspecialchars($row['role']);
            } else {
                $_SESSION['error'] = "Utilisateur introuvable.";
                header("Location: ../admin/personnel.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Erreur lors de l'accès au compte : " . $stmt->error;
            header("Location: ../admin/personnel.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Erreur de préparation de la requête : " . $conn->error;
        header("Location: ../admin/personnel.php");
        exit();
    }
} else {
    $_SESSION['error'] = 'Une erreur est survenue.';
    header('Location: ../admin/personnel.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du personnel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "../php/btnBack.php"; ?> <!-- bouton de retour -->
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- navBarr -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    
    <main class="admin">
        <h1 id="titleAvis">Gestion du personnel</h1>
        <div id="modifPersonneForm" style =" position:relative; ">
            <h3>Modifier un membre</h3>
            <form id="modifUser" method="POST" action="../admin/modifUser.php">
            <?php back('personnel', $align = 'c'); ?>
                <input type="hidden" name="id" value="<?= isset($id) ? $id : ''; ?>">

                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required value="<?= $name; ?>">

                <label for="surname">Prénom :</label>
                <input type="text" id="surname" name="surname" required value="<?= $surname; ?>">

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required value="<?= $email; ?>" autocomplete="off">

                <label for="role">Rôle :</label>
                <select id="role" name="role" style="margin-bottom: 15px;" required>
                    <option value="" disabled>Sélectionnez un rôle</option>
                    <option value="agent" <?= $role === 'agent' ? 'selected' : ''; ?>>Agent</option>
                    <option value="veterinaire" <?= $role === 'veterinaire' ? 'selected' : ''; ?>>Vétérinaire</option>
                </select>
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" id="password" name="password" autocomplete="off">

                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" autocomplete="off">

                <br>

                <button type="submit">Soumettre</button>
            </form>
        </div>
        <div id="showPersonne" style="text-align: center;">
            <?php include_once "../back/showUsers.php"; ?>
        </div>
    </main>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/popup.js"></script>
</body>
</html>
