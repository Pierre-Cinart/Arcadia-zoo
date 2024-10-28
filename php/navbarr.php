<?php include_once "../php/btnBack.php"; //  bouton retour configurable back('url sans extension')'?>
<style>
    /* boutton de retour */

    .btn-back {
        transform : translateY(-50%);
        position: absolute;
        width: 80px;
        font-size: 12px; 
        padding: 8px 8px; 
        background-color: #275e6e;
        color: white; 
        text-decoration: none;
        border : solid 1px #275e6e;  
        border-radius: 5px; 
        transition: background-color 0.3s; 
    }

    .btn-back:hover {
        background-color: #4c79ad; 
    }
   
    
</style> 
<nav class="menu">
    <a href="./accueil.php"><img src="../img/logo.png" alt="logo"></a>
    <button class="menu-toggle" aria-label="Toggle menu">&#9776;</button>
    <ul>
        <li><a href="./accueil.php">Accueil</a></li>
        <li><a href="./services.php">Services</a></li>
        <li><a href="./habitats.php">Nos Animaux</a></li>
        <li><a href="./avis.php">Avis</a></li>
        <li><a href="./contact.php">Contact</a></li>
    </ul>
</nav>


