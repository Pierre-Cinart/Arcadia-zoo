<!-- navBarr pages admin -->
<nav class="menu">
    <a href="./accueil.php"><img src="../img/logo.png" alt="logo"></a>
    <button class="menu-toggle" aria-label="Toggle menu">&#9776;</button>
    <ul>
    <?php
      if (isset($_SESSION['role'])) {
         $role = $_SESSION['role'];
      }
      
      $role = $_SESSION['role'];
         if (isset($role) && $role === 'admin'){
            echo '<li><a href="../admin/personnel.php">Personnel</a></li>';
            echo '<li><a href="../admin/stats.php">Statistiques</a></li>';
         }
    
         if (isset($role) && ($role === 'admin' || $role === 'agent' || $role === 'veterinaire')){
            echo '<li><a href="../admin/services.php">Services</a></li>';
            echo '<li><a href="../admin/animaux.php">Animaux</a></li>';  
         }
    
         if (isset($role) && ($role === 'admin' || $role === 'agent')){
            echo '<li><a href="../admin/avis.php">Avis</a></li>';
            echo '<li><a href="../admin/messages.php">Messages</a></li>';
         }
    ?>
        <li><a href="../index.php" target="_blank">Voir le site</a></li>
    </ul>
</nav>
