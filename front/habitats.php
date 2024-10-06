<?php
session_start();

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
        <h1>Explorez Nos Habitats et Découvrez Nos Animaux !</h1>
    </header>
    <main >
        <p> 
            Bienvenue à Arcadia Zoo, où la nature vous invite à découvrir des animaux fascinants dans leurs habitats recréés avec soin. 
            En explorant chaque environnement, vous pourrez en apprendre davantage sur ces créatures étonnantes. 
            Cliquez sur les images pour en savoir plus sur les animaux de chaque habitat !
        </p>
        <section class = "habitat">
            
            <div>
            <!-- SAVANE -->
                <h2>La Savane : Le Royaume des Grands Espaces</h2>
                <div class = "habitat-card">
                    <img src="" alt="savane">
                    <div class="habitat-card-txt">
                        <p>
                            Entrez dans la savane, un vaste paysage ouvert, baigné de soleil et parsemé d’herbes dorées. 
                            Cet habitat vous plonge au cœur des plaines africaines, où des animaux majestueux cohabitent.
                        </p>
                        <h3>Rencontrez nos résidents :</h3>
                        <ul>
                            <li> <strong>Lions</strong> : Rois incontestés de la savane, ces grands félins règnent en maîtres.</li>
                            <li> <strong>Girafes</strong> : Les plus grands mammifères terrestres, avec leurs longs cous et leurs taches uniques.</li>
                            <li><strong>Éléphants d’Afrique</strong> : Ces géants doux impressionnent par leur taille et leur sagesse.</li>
                            <li><strong>Zèbres</strong> : Leurs rayures distinctes ajoutent un charme unique au paysage.</li>
                        </ul>
                        <button>Voir les animaux</button>
                    </div>
                </div>
            </div>
            <!-- JUNGLE -->
            <div>
                <h2>La Jungle : Un Monde de Mystère et de Couleurs</h2>
                <div class = "habitat-card">
                    <img src="" alt="jungle">
                    <p>
                        La jungle est dense et vibrante, avec des arbres imposants et une végétation luxuriante. 
                        Ici, le chant des oiseaux exotiques et les mouvements des créatures cachées rythment la vie.
                    </p>
                    <h3>Découvrez nos habitants :</h3>
                    <ul>
                        <li> <strong>Tigres</strong> : Redoutables chasseurs et maîtres de la discrétion, ces félins sont de véritables symboles de puissance.</li>
                        <li> <strong>Singes capucins</strong> : Petits mais agiles, ils se déplacent avec aisance dans les arbres et sont réputés pour leur intelligence.</li>
                        <li> <strong>Panthères</strong> : Silencieuses et gracieuses, elles se fondent dans les ombres de la jungle.</li>
                    </ul>
                    <button>Voir les animaux</button>
                </div>
                
            </div>
            <!-- MARAIS -->
            <div>
                <h2>Les Marais : Un Refuge Aquatique</h2>
                <div class = "habitat-card">
                    <img src="" alt="jungle">
                    <p>
                        Les marais sont des lieux calmes où l’eau et la terre se rejoignent, créant un refuge pour une faune surprenante. 
                        C’est un habitat où chaque espèce a su s’adapter à la vie dans l’eau et sur terre.
                    </p>
                    <h3>Découvrez nos résidents aquatiques :</h3>
                    <ul>
                        <li> <strong>Crocodiles du Nil</strong> : Redoutables prédateurs qui règnent dans les eaux des marais.</li>
                        <li> <strong>Hippopotames</strong> : Ces colosses passent leurs journées à se prélasser dans l’eau pour se protéger du soleil.</li>
                        <li> <strong>Flamants roses</strong> : Élégants et gracieux, ces oiseaux aux plumes roses ajoutent une touche de couleur à cet habitat.</li>
                    </ul>
                    <button>Voir les animaux</button>
                </div>
            </div>
        </section>
        <br>
    </main>
    <?php include_once "../php/footer.php"; ?>
</body>
</html>