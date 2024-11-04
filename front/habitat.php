<?php
session_start();
//connexion à la base de données 
include_once ( '../back/bdd.php' );
// Récupère l'ID de l'habitat depuis le paramètre GET et vérifie s'il est valide
if (isset($_GET['habitat_id']) && is_numeric($_GET['habitat_id'])) {
    $habitatId = intval($_GET['habitat_id']);
    
    // Requête pour vérifier si l'habitat existe
    $sql = "SELECT name, title_txt, description, picture FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $habitatId);
    $stmt->execute();
    $result = $stmt->get_result();
    $habitat = $result->fetch_assoc();
    
    // Si l'habitat n'est pas trouvé, redirige vers habitats.php
    if (!$habitat) {
        header("Location: habitats.php");
        exit();
    }

    // Requête pour récupérer les races liées à cet habitat
    $sqlRaces = "SELECT id, name FROM races WHERE habitat = ?";
    $stmtRaces = $conn->prepare($sqlRaces);
    $stmtRaces->bind_param("i", $habitatId);
    $stmtRaces->execute();
    $resultRaces = $stmtRaces->get_result();
    
    // Tableau pour stocker les races
    $races = [];
    while ($race = $resultRaces->fetch_assoc()) {
        $races[] = $race;
    }
} else {
    // Si l'ID est invalide, redirige vers habitats.php
    header("Location: habitats.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title><?php echo htmlspecialchars($habitat['title_txt']); ?></title>
    <style>
        /* Style body */
        body {
            min-height: 100vh;
            display: flex;
            justify-content: space-between;
            background-image: url('../img/habitats/<?php echo htmlspecialchars($habitat['picture']); ?>.webp');
            background-size: cover;
            background-position: center;
            color: white;
        }
        /* Style container du titre  */
        .container {
            position: relative;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7); /* Fond transparent pour le texte */
            max-width: 800px;
            margin: auto;
            border-radius: 10px;
            font-weight: normal;
        }
        a {
            color:white;
            text-decoration : none;
        }
        .animals_list {
            list-style: none;
            margin-left:50%;
            text-align: left;
            transform: translate(-50%, 0); 
        }
        h3 {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; ?>
    </header>
    <br>
    <main>
        <div class="container">
            <h1><?php echo htmlspecialchars($habitat['title_txt']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars_decode($habitat['description'])); ?></p>
            <?php echo  back("habitats","r"); ?>
        </div>
        <br>
        <div class="container" style = "text-align:center;">
              <!-- Affiche les races liées à cet habitat -->
            <h3>Animaux dans cet habitat :</h3>
            <?php
            if (count($races) > 0) {
                echo '<ul class = "animals_list">';
                foreach ($races as $race) {
                    echo '<li><a href="./animaux.php?id=' . htmlspecialchars($race['id']) . 
                    '">' . htmlspecialchars($race['name']) . ' :<img src="../img/animaux/Capucins/capucin2.webp" alt="'.htmlspecialchars($race['name']).'">  </a></li>';
                }
                echo '</ul>';
        echo  '</div>' . back("habitats","r"); 
            } else {
                echo '<p>Aucune race disponible dans cet habitat.</p>';
            }?>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>
