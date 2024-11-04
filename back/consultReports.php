<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'agent' && $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'veterinaire') || 
    !isset($_SESSION['user_id'])) {
    
    $_SESSION['error'] = 'Veuillez vous connecter en tant qu\'administrateur pour accéder à cette page.';
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else {
    $id = $_SESSION['user_id'];
    // Connexion à la base de données
    include_once './bdd.php';

    // Pour l'utilisation du token
    include_once './token.php';

    checkToken($conn); // Vérifie si le token de session est correct et le met à jour
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['choice'])) {
        $_SESSION['error'] = 'Erreur de choix';
        header('Location: ../admin/reports.php');
        $conn->close();
        exit();
    } else {
        $choice = $_POST['choice'];
    }
} else {
    $_SESSION['error'] = 'Erreur de méthode';
    header('Location: ../admin/reports.php');
    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion animaux</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>p{text-align : center;font-size : 18px;} h3{font-size : 22px;} .little{font-size : 14px}</style>
<body>  
    <?php include_once "../php/btnBack.php"; ?>  <!-- bouton de retour -->    
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>  <!-- Navbar -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->
   
    <main class="admin">
        <div>
            <?php echo back('../admin/reports', "r");  // Lien de retour 
            switch ($choice) {
                // Rapport de nourriture
                case 'food': {
                    if (empty($_POST['race'])) {
                        $_SESSION['error'] = 'Erreur de choix, la race n\'est pas spécifiée.';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit(); 
                    } else {
                        $race_name = $_POST['race']; // Récupérer le nom de la race
                    }

                    // Préparation d'une requête pour obtenir l'ID de la race à partir du nom
                    $stmt_race = $conn->prepare("SELECT id FROM races WHERE name = ?");
                    $stmt_race->bind_param("s", $race_name); // Lier le nom de la race
                    $stmt_race->execute();
                    $stmt_race->bind_result($race_id);
                    $stmt_race->fetch();
                    $stmt_race->close();

                    // Vérifier si l'ID de la race a été trouvé
                    if (!$race_id) {
                        $_SESSION['error'] = 'Aucune race trouvée avec ce nom.';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit();
                    }

                    // Préparation de la requête pour récupérer les informations de nourriture
                    $stmt = $conn->prepare("SELECT f.quantity, u.first_name, u.name, f.food_date FROM food_reports f 
                                             JOIN users u ON f.user_id = u.id 
                                             WHERE f.race_id = ?");
                    $stmt->bind_param("i", $race_id); // Lier l'ID de la race
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Vérifier si des données ont été récupérées
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $quantity = $row['quantity'];
                            $user_name = $row['first_name'] . ' ' . $row['name']; // Nom de l'utilisateur
                            $date_reported = new DateTime($row['food_date']); // Crée un objet DateTime
                            $formatted_date = $date_reported->format('d/m/Y à H:i'); // Format français
                        }

                        // Affichage des informations
                        echo '<br><h3>Rapport de Nourriture : ' . htmlspecialchars($race_name) . '</h3>';
                        echo '<p>Quantité distribuée : ' . htmlspecialchars($quantity) . ' kg</p><br>'; 
                        echo '<p class = "little">Le : ' . htmlspecialchars($formatted_date) . '</p>';
                        echo '<p class = "little">par : ' . htmlspecialchars($user_name) . '</p>'; 
                         
                    } else {
                        echo '<h3>Aucune donnée de nourriture trouvée pour cette race.</h3>';
                    }

                    $stmt->close();
                }
                break;
                

                // Rapport de santé  
                case 'health': {
                    if (empty($_POST['name'])) {
                        $_SESSION['error'] = 'Erreur de choix';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit();
                    } else {
                        $name = $_POST['name'];
                    }    

                    // Préparation d'une requête pour obtenir l'ID de l'animal à partir du nom
                    $stmt_animal = $conn->prepare("SELECT id FROM animals WHERE name = ?");
                    $stmt_animal->bind_param("s", $name); // Lier le nom de l'animal
                    $stmt_animal->execute();
                    $stmt_animal->bind_result($animal_id); // assignation de l id à animal_id
                    $stmt_animal->fetch();
                    $stmt_animal->close();

                    // Vérifier si l'ID de l'animal a été trouvé
                    if (!$animal_id) {
                        $_SESSION['error'] = 'Aucun animal trouvé avec ce nom.';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit();
                    }

                    // Préparation de la requête pour récupérer le dernier rapport de santé
                    $stmt_health = $conn->prepare("SELECT ar.report_date, ar.report_txt, u.first_name, u.name 
                                                    FROM animal_reports ar 
                                                    JOIN users u ON ar.user_id = u.id 
                                                    WHERE ar.animal_id = ? 
                                                    ORDER BY ar.report_date DESC LIMIT 1");
                    $stmt_health->bind_param("i", $animal_id); // Lier l'ID de l'animal
                    $stmt_health->execute();
                    $result_health = $stmt_health->get_result();

                    // Vérifier si des données ont été récupérées
                    if ($result_health->num_rows > 0) {
                        $row = $result_health->fetch_assoc();
                        $date_reported = new DateTime($row['report_date']); // Crée un objet DateTime
                        $formatted_date = $date_reported->format('d/m/Y à H:i'); // Format français
                        $report_txt = $row['report_txt'];
                        $user_name = $row['first_name'] . ' ' . $row['name']; // Nom de l'utilisateur

                        // Affichage des informations
                        echo '<br><h3>Dernier Rapport de Santé pour : ' . htmlspecialchars($name) . '</h3>';
                        echo '<p>' . nl2br(htmlspecialchars($report_txt)) . '</p><br>'; // Afficher le texte du rapport
                        echo '<p class = "little">Le : ' . htmlspecialchars($formatted_date) . '</p>';
                        echo '<p class = "little">par : ' . htmlspecialchars($user_name) . '</p>'; 
                    } else {
                        echo '<h3>Aucun rapport de santé trouvé pour cet animal.</h3>';
                    }

                    $stmt_health->close();
                }
                break;
                // rapport complet 
                case 'full': {
                    // Vérifier les dates de début et de fin
                    if (empty($_POST['endDate']) || empty($_POST['startDate'])) {
                        $_SESSION['error'] = 'Les dates de début et de fin doivent être spécifiées.';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit();
                    } else {
                        $start_date = date('Y-m-d', strtotime($_POST['startDate']));
                        $end_date = date('Y-m-d', strtotime($_POST['endDate']));  
                       
                        // Inverser les dates si nécessaire
                        if (strtotime($end_date) < strtotime($start_date)) {
                            $temp = $start_date;
                            $start_date = $end_date;
                            $end_date = $temp;
                        }
                        $end_date = date('Y-m-d', strtotime($end_date . ' +1 day')); // pour afficher aussi les rapports à la date selectionnée
                    }
                    // Vérifier si le nom de l'animal est défini
                    if (empty($_POST['name'])) {
                        $_SESSION['error'] = 'Aucun animal spécifié.';
                        header('Location: ../admin/reports.php');
                        $conn->close();
                        exit();
                    } else {
                        $name = $_POST['name'];
                    }
                    
                    // Récupérer l'ID de l'animal à partir de son nom
                    $stmt = $conn->prepare("SELECT id, race_id FROM animals WHERE name = ?");
                    $stmt->bind_param("s", $name);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    // Vérifie si l'animal existe
                    if ($result && $result->num_rows > 0) {
                        $animal_data = $result->fetch_assoc();
                        $animal_id = $animal_data['id'];
                        $race_id = $animal_data['race_id'];
                    }
                
                    // Préparation de la requête pour récupérer les informations de nourriture
                    $stmt = $conn->prepare("SELECT f.quantity, u.first_name, u.name, f.food_date FROM food_reports f 
                                             JOIN users u ON f.user_id = u.id 
                                             WHERE f.race_id = ? AND f.food_date >= ? AND f.food_date <= ?");
                    $stmt->bind_param("iss", $race_id, $start_date, $end_date); // Lier l'ID de la race
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    // Vérifier si des données ont été récupérées pour les rapports de nourriture
                    if ($result->num_rows > 0) {
                        echo '<br><h3>Rapports de Nourriture : ' . htmlspecialchars($name) . '</h3>';
                        while ($row = $result->fetch_assoc()) {
                            $quantity = $row['quantity'];
                            $user_name = $row['first_name'] . ' ' . $row['name']; // Nom de l'utilisateur
                            $date_reported = new DateTime($row['food_date']); // Crée un objet DateTime
                            $formatted_date = $date_reported->format('d/m/Y à H:i'); // Format français
                            echo '<p>Quantité distribuée : ' . htmlspecialchars($quantity) . ' kg</p><br>'; 
                            echo '<p class="little">Le : ' . htmlspecialchars($formatted_date) . '</p>';
                            echo '<p class="little">par : ' . htmlspecialchars($user_name) . '</p><br>'; 
                            echo '<p class="little">---------------------------------------</p><br>';
                        }
                        echo '<p class="little">---------------------------------------</p><br>';
                    } else {
                        echo '<h3>Aucune donnée de nourriture trouvée pour cette race.</h3>';
                    }
                
                    // Préparation de la requête pour récupérer tous les rapports de santé
                    $stmt_health = $conn->prepare("SELECT ar.report_date, ar.report_txt, u.first_name, u.name 
                                                    FROM animal_reports ar 
                                                    JOIN users u ON ar.user_id = u.id 
                                                    WHERE ar.animal_id = ? AND ar.report_date >= ? AND ar.report_date <= ?
                                                    ORDER BY ar.report_date DESC");
                    $stmt_health->bind_param("iss", $animal_id, $start_date, $end_date); // Lier l'ID de l'animal
                    $stmt_health->execute();
                    $result_health = $stmt_health->get_result();
                
                    // Vérifier si des données ont été récupérées pour les rapports de santé
                    if ($result_health->num_rows > 0) {
                        echo '<br><h3>Rapports de Santé pour : ' . htmlspecialchars($name) . '</h3>';
                        while ($row = $result_health->fetch_assoc()) {
                            $date_reported = new DateTime($row['report_date']); // Crée un objet DateTime
                            $formatted_date = $date_reported->format('d/m/Y à H:i'); // Format français
                            $report_txt = $row['report_txt'];
                            $user_name = $row['first_name'] . ' ' . $row['name']; // Nom de l'utilisateur
                
                            // Affichage des informations
                            echo '<p>' . nl2br(htmlspecialchars($report_txt)) . '</p><br>'; // Afficher le texte du rapport
                            echo '<p class="little">Le : ' . htmlspecialchars($formatted_date) . '</p>';
                            echo '<p class="little">par : ' . htmlspecialchars($user_name) . '</p><br>';
                            echo '<p class="little">---------------------------------------</p><br>'; 
                        }
                    } else {
                        echo '<h3>Aucun rapport de santé trouvé pour cet animal.</h3>';
                    }
                
                    $stmt_health->close();
                } break;
                
                default:
                    $_SESSION['error'] = 'Choix nul ou invalide';
                    header('Location: ../admin/reports.php');
                    $conn->close();
                    exit();
            }
            ?>
        </div>
    </main>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/popup.js"></script>
    <?php $conn->close(); ?> <!-- fermeture de connexion bdd -->
</body>
</html>
