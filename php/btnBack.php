
<?php

function back( $url){
    echo '<form class ="logout" action=" ' . $url .'.php" method="post">';
    echo '<button type="submit" class="btn-back"> <<< Retour</button></form>';
}
    

    
