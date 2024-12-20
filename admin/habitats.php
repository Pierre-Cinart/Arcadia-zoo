<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' 
&& $_SESSION['role'] !== 'agent' )){
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité , veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
     // Connexion à la base de données
    include_once '../back/bdd.php';
    // pour utilisation de token
    include_once '../back/token.php';
     checkToken($conn);// verifie si le token de session est correct et le met à jour
     // pour les boutons retour
     include_once "../php/btnBack.php"; 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitats</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "../php/popup.php"; ?>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <div style = "display: flex; justify-content: center; gap: 10px;margin:20px;">
        <button id="addHabitatBtn" onclick = "toggleForm()">Ajouter un habitat</button>
    </div>
    <main>
    
    <div id="createHabitat" style = "display : none;">
            <h3>Ajouter un habitat : </h3>
            <form id="createHabitatForm" method="POST" action="../back/createHabitat.php" enctype="multipart/form-data">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>

                <label for="title-txt">En-tête :</label>
                <input type="text" id="title-txt" name="title-txt" required>

                <label for="description">Description :</label>
                <input type="text" id="description" name="description" required>
                
                
                <label for="picture">Image du service : (format autorisé : webp)</label>
                <input type="file" id="picture" name="picture" accept=".webp" required>
                
                <br>
                <button type="submit">Soumettre</button>
            </form>
        </div>
        <section class="habitat">
            <?php
                // Préparation de la requête pour récupérer les habitats et leurs races
                $sql = "SELECT h.id AS habitat_id, h.name AS habitat_name, h.title_txt, h.description, h.picture, r.id AS race_id, r.name AS race_name
                        FROM habitats h
                        LEFT JOIN races r ON h.id = r.habitat
                        ORDER BY h.id";
                
                $result = $conn->query($sql);
                
                // Tableau pour organiser les données
                $habitats = [];
                
                while ($row = $result->fetch_assoc()) {
                    $habitatId = $row['habitat_id'];
                    
                    // Vérifie si l'habitat existe déjà dans le tableau
                    if (!isset($habitats[$habitatId])) {
                        $habitats[$habitatId] = [
                            'id' => $row['habitat_id'],
                            'name' => $row['habitat_name'],
                            'title_txt' => $row['title_txt'],
                            'description' => $row['description'],
                            'picture' => $row['picture'],
                            'races' => []
                        ];
                    }
                    
                    // Ajoute la race avec son ID si elle existe
                    if ($row['race_name']) {
                        $habitats[$habitatId]['races'][] = [
                            'id' => $row['race_id'],
                            'name' => $row['race_name']
                        ];
                    }
                }

                // Affiche les habitats et leurs races
                foreach ($habitats as $habitat) {
                    $imagePath = "../img/habitats/" . htmlspecialchars($habitat['picture']) . ".webp";
                    echo "<article>";
                        echo '<div class="action-buttons" 
                            style = "background-color : #c7d31ab0; ; 
                            padding : 10px; width:80px; border : solid black 1px ;border-radius : 10px; 
                            transform : translateY(50px); margin-left : 5px;">';
                            echo '<a href="../back/modifHabitat.php?id=' . intval($habitat['id']) . '
                                " class="edit-button"><img src="../img/icones/modif.png" alt="Modifier"></a>';
                            echo '<a href="" class="delete-button" onclick="confirmDelete(event, ' . intval($habitat['id']) . ')">
                                <img src="../img/icones/supp.png" alt="Supprimer"></a>';                            
                        echo '</div>'; 
                        echo '<div class="habitat-card">';
                            echo "<h2>" . htmlspecialchars($habitat['title_txt']) . "</h2>";
                            echo "<img src='$imagePath' alt='" . htmlspecialchars($habitat['name']) . "'>";
                            echo '<div class="habitat-card-txt">';
                                echo "<p>" . nl2br(htmlspecialchars_decode($habitat['description'])) . "</p>";
                                echo "<h3>Rencontrez nos résidents :</h3>";
                                echo "<ul>";
                                foreach ($habitat['races'] as $race) {
                                    $raceId = htmlspecialchars($race['id']);
                                    $raceName = htmlspecialchars($race['name']);
                                    echo "<li>$raceName</li>";
                                }
                                echo "</ul>";
                                
                                // Bouton "Voir les animaux" avec l'ID de l'habitat
                                echo "<a href='./animal.php?habitat_id=" . intval($habitat['id']) . "' class='btn'><button>Voir les animaux</button></a>";
                                
                            echo "</div>";
                        echo "</div>";
                        echo back("./animaux","r");
                    echo "</article>";                  
                }
            ?>
           </section>
           
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/popup.js"></script>
    <script src="../js/habitats.js"></script>
</body>
</html>
