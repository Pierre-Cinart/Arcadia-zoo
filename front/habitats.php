<?php
session_start();
//rendre cette page dynamique !
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitats</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarr.php"; ?> <!-- navbarr -->
    </header>
    <main>
        <h1>Explorez Nos Habitats et Découvrez Nos Animaux !</h1>
        <p> 
            Bienvenue à Arcadia Zoo, où la nature vous invite à découvrir des animaux fascinants dans leurs habitats recréés avec soin. 
            En explorant chaque environnement, vous pourrez en apprendre davantage sur ces créatures étonnantes. 
            Cliquez sur les images pour en savoir plus sur les animaux de chaque habitat !
        </p>
        <section class="habitat">
            <article>
                <!-- SAVANE -->
                <h2>La Savane : Le Royaume des Grands Espaces</h2>
                <div class="habitat-card">
                    <img src="../img/habitats/Savane.webp" alt="savane">
                    <div class="habitat-card-txt">
                        <p>
                            Entrez dans la savane, un vaste paysage ouvert, baigné de soleil et parsemé d’herbes dorées. 
                            Cet habitat vous plonge au cœur des plaines africaines, où des animaux majestueux cohabitent.
                        </p>
                        <h3>Rencontrez nos résidents :</h3>
                        <ul>
                            <li><strong>Lions</strong></li>
                            <li><strong>Girafes</strong></li>
                            <li><strong>Éléphants d’Afrique</strong></li>
                        </ul>
                        <button><a href="./savane.php">Voir les animaux</a></button>
                    </div>
                </div>
            </article>

            <article>
                <!-- JUNGLE -->
                <h2>La Jungle : Un Monde de Mystère et de Couleurs</h2>
                <div class="habitat-card">
                    <img src="../img/habitats/Jungle.webp" alt="jungle">
                    <div class="habitat-card-txt">
                        <p>
                            La jungle un lieu dense et vibrant, avec de nombreux arbres imposants et une végétation luxuriante. 
                        </p>
                        <h3>Découvrez nos habitants :</h3>
                        <ul>
                            <li><strong>Tigres</strong></li>
                            <li><strong>Singes capucins</strong></li>
                            <li><strong>Panthères</strong></li>
                        </ul>
                        <button><a href="./jungle.php">Voir les animaux</a></button>
                    </div>
                </div>
            </article>

            <article>
                <!-- MARAIS -->
                <h2>Les Marais : Un Refuge Aquatique</h2>
                <div class="habitat-card">
                    <img src="../img/habitats/Marais.webp" alt="marais">
                    <div class="habitat-card-txt">
                        <p>
                            Les marais sont des lieux calmes où l’eau et la terre se rejoignent, créant un refuge pour une faune surprenante. 
                            C’est un habitat où chaque espèce a su s’adapter à la vie dans l’eau et sur terre.
                        </p>
                        <h3>Découvrez nos résidents aquatiques :</h3>
                        <ul>
                            <li><strong>Crocodiles du Nil</strong></li>
                            <li><strong>Hippopotames</strong></li>
                            <li><strong>Flamants roses</strong></li>
                        </ul>
                        <button><a href="./marais.php">Voir les animaux</a></button>
                    </div>
                </div>
            </article>
        </section>
    </main>
    <?php include_once "../php/footer.php"; ?>
    <script src="../js/toggleMenu.js"></script>
</body>
</html>
