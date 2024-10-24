<?php
// Fichier de fonctions pour le token //

function createToken() { 
    // Génère un token de 128 caractères aléatoires 
    return bin2hex(random_bytes(64));
}

// Mise à jour du token
function updateToken($conn, $token, $user_id) {
    if (!isset($conn) || !isset($token) || !isset($user_id)) {
        session_unset();
        $_SESSION['error'] = "Une erreur est survenue, veuillez vous reconnecter.";
        header('location:../admin/index.php');
        exit();
    }

    // Vérifier si l'utilisateur existe avant de mettre à jour le token
    $checkUserSql = "SELECT id FROM users WHERE id = ?";
    $checkStmt = $conn->prepare($checkUserSql);
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $update_sql = "UPDATE users SET token = ?, token_expiration = CURRENT_TIMESTAMP + INTERVAL 2 HOUR WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $token, $user_id);

        if ($update_stmt->execute()) {
            // Le token a été mis à jour avec succès
        } else {
            // Gestion de l'erreur de mise à jour
            session_unset();
            $_SESSION['error'] = "Une erreur est survenue lors de la mise à jour du token.";
            header('location:../admin/index.php');
            exit();
        }
        $update_stmt->close();
    }
    $checkStmt->close();
}

// Vérifie la validité du token
function checkToken($conn) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['token'])) {
        $user_id = (int)$_SESSION['user_id']; 
        $token = $_SESSION['token'];

        // Préparer la requête pour vérifier le token et son expiration
        $checkTokenSql = "SELECT token, token_expiration FROM users WHERE id = ?";
        $checkStmt = $conn->prepare($checkTokenSql);
        $checkStmt->bind_param("i", $user_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $row = $checkResult->fetch_assoc();
            $dbToken = $row['token'];
            $dbTokenExpiration = $row['token_expiration'];

            // Vérifier si le token correspond et si l'expiration est valide
            if ($token === $dbToken && new DateTime() < new DateTime($dbTokenExpiration)) {
                //mettre à jour le token
                updateToken($conn, $token , $user_id);
                return true; // Le token est valide
            } else {
                // Le token a expiré ou ne correspond pas
                session_unset();
                $_SESSION['error'] = "Session invalide ou expirée. Veuillez vous reconnecter.";
                header('location:../admin/index.php');
                exit();
            }
        } else {
            // L'utilisateur n'existe pas
            session_unset();
            $_SESSION['error'] = "Une erreur est survenue. Veuillez vous reconnecter.";
            header('location:../admin/index.php');
            exit();
        }
    } else {
        // Supprimer toutes les variables de session
        session_unset();
        $_SESSION['error'] = "Une erreur est survenue, veuillez vous reconnecter.";
        header('location:../admin/index.php');
        exit();
    }
}
?>
