laisse le code avant la verification de la methode post 

etape 1 recupérer l id renvoyé dans modifName l ' enregistrer dans $animal_id(int) 

etape 2 recupérer les données de l animal avec l id $animal_id les enregistrer 
dans un tableau pour pouvoir les comparer avec les resultats du formulaire 

etape 3 recupérer les données du formulaire comparer les données du formulaire (non vide) avec celle du Tableau si vide assigner la donnée du tableau 
à la variable au lieu de celle du formulaire si tout est vide renvoyer 
session success = aucun changement effectuer et revenir sur ../admin/animaux.php


etape 4 verifier si la race à changer , si elle a changé et différent de autre , l attribuer à $race_id(int)
si === autre verifier que l input de nouvelle race ne contient que des caractère alphabetique et qu il ne soit pas vide si non renvoit sur la page ../admin/animaux.php
avec un session error = à l erreur 

si === autre et que les regex sont bon assigner le resultat de linput txt à $race_name 
faire une requete  et verifier l habitat de la mm facon pour $habitat_name
si c est bon assigner input text du nouvel habitat à $habitat_name
pareil si l habitat 
 si isset($habitat_name) 
creer l habitat insert into habitats (name ,title_txt,description ,picture ,maj_by) ---> $habitat_name , "" ,"" ,"" , $user_id puis 
faire un requet pour récupére l id de l habitat where name === $habitat_name et assigner cette id à $habitat_id 
/si non $habitat_id = modifHabitatID 


etape 6 verifier le regime  : si la race n as pas changé , ne pas changer le régime non plus / 
si vide envoyer session error = 'vous avez créez une nouvelle race sans lui attribuer de regime'et renvoyer vers la page animaux' 
si non verifier qu il soit egale à 'carnivore' || 'omnivore' || 'herbivore'
si true $regime = le resultats si non erreur regime inexistant

avec ceci nous pouvons créer la nouvelle race :  insert into races (name , habitat , regime ) --> $race_name , $habitat_id , $regime
puis recupérer son id : select id from races where name = $race_name

etape 7 comparé les description si différent assigné la nouvelle description à $description si non recupérer celle d origine 
pareil pour le sex et la date de naissance pareil pour santé 

// pour les images je vais recupérer le mm code que pour la création 

ensuite avec toutes ces infos on peut update animals where id = $animal_id 
// Afficher les données pour le débogage
$responseData = [
        'animalData' => $animalData,
        'postData' => $_POST,
        'NAME' => $name,
        'RACE' => $race,
        'TXT' => $description,
        'REGIME' => $regime,
        'HABITAT' => $habitat,
        'REGIME' => $regime
    ];
    echo json_encode($responseData);


