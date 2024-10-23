<!-- navBarr pages admin -->
<nav class="menu">
    <a href="./accueil.php"><img src="../img/logo.png" alt="logo"></a>
    <button class="menu-toggle" aria-label="Toggle menu">&#9776;</button>
    <ul>
    <?php
         if (isset($role) && $role === 'admin'){
            echo '<li><a href="./personnel.php">Personnel</a></li>';
            echo '<li><a href="./stats.php">Statistiques</a></li>';
         }
    
         if (isset($role) && ($role === 'admin' || $role === 'agent' || $role === 'veterinaire')){
            echo '<li><a href="./animaux.php">Animaux</a></li>';  
         }
    
         if (isset($role) && ($role === 'admin' || $role === 'agent')){
            echo '<li><a href="./avis.php">Avis</a></li>';
            echo '<li><a href="./messages.php">Messages</a></li>';
         }
    ?>
        <li><a href="../index.php" target="_blank">Voir le site</a></li>
    </ul>
</nav>
