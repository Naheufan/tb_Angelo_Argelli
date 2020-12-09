
<?php
/*
  Auteur  : Angelo Argelli
  Fichier : functions.php
  Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

  Contient des fonctions utilisées à plusieurs reprises
*/
//fonction d'initialisation du PDO
function connect(){
    $config = parse_ini_file(realpath('../../db/db.ini'));
    try{
      $con = new PDO('mysql:host=localhost:3306;dbname='.$config['db'], $config['username'],$config['password']);
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
    return $con;
}
//fonction de vérification du possesseur d'un sujet
//retourne true si l'id de personne transmis correspond à l'id trouvé pour un sujet à l'id donné
function isOwner($personId, $subjectId){
  $bdd = connect();
  $sqlQuery=$bdd->prepare("SELECT count(id) as 'r' FROM v_sujet where idPersonne = $personId AND id = $subjectId");
  $sqlQuery->execute();
  $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);
  if($result['r'] == 1){return TRUE;}
  else{return FALSE;}
}
?>
