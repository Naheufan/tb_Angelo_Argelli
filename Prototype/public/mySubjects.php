<?php
/*
  Auteur  : Angelo Argelli
  Fichier : mySubjects.php
  Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

  page des sujets concernant la personne connectée
*/
  //initialisation
  include('functions.php');
  session_start();
  if(!isset($_SESSION['userId'])){
    header('location: login.php');
  }
  $bdd = connect();
  $userId = $_SESSION['userId'];
  $userType = $_SESSION['userType'];
  $personType = $_SESSION['personType'];
  $filiere = $_SESSION['idFiliere'];
  $personId = $_SESSION['personId'];
  //traitement des boutons
  if(isset($_POST['edit'])){
    if(isOwner($personId,$_POST['edit']))
    {
      $_SESSION['from'] = "mySubjects";
      header('location: editSubject.php?id='.$_POST['edit']);
    }
  }
  if(isset($_POST['delete'])){
    if(isOwner($personId,$_POST['delete']))
    {
      $subjectId = $_POST['delete'];
      $stmt = $bdd->prepare("DELETE FROM v_edit_sujet WHERE id = $subjectId");
      $stmt->execute();
    }
  }
  //définition du champ de recherche
  $sqlQuery="SELECT * FROM v_sujet where idPersonne = $personId";
  $stmt = $bdd->query($sqlQuery);
  $rowCount = $stmt->rowCount();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sujets de TB - Mes Sujets</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/mySubjects.css">
  </head>
  <body>
    <div id="navbar">
      <a href="index.php?filiere=1"><div class="navbarCell">IG <div class="tooltip">Informatique de Gestion</div></div></a>
      <a href="index.php?filiere=2"><div class="navbarCell">ID <div class="tooltip">Information Documentaire</div></div></a>
      <a href="index.php?filiere=3"><div class="navbarCell">EE <div class="tooltip">Économie d'Entreprise</div></div></a>
      <a href="index.php?filiere=4"><div class="navbarCell">IBM<div class="tooltip">International Business Management</div></div></a>
      <a href="index.php?filiere=0"><div class="navbarCell">Divers</div></a>
      <a href="logout.php"><div class="navbarCell rightCells"> X <div class="tooltip">Déconnexion</div></div></a>
      <a href="addSubject.php"><div class="navbarCell rightCells">Proposer un Sujet</div></a>
      <a href="mySubjects.php"><div class="navbarCell selectedCell rightCells" >Mes Sujets</div></a>
      <a href="documents.php"><div class="navbarCell rightCells">Documents</div></a>
      <?php if($userType == "admin"){echo '<a href="subjectsManager.php"><div class="navbarCell rightCells" >Gestion</div></a>';}?>
    </div>
    <div id="container">
      <div id="containerTitle">Vos sujets proposés</div>
      <div id="itemListBody">
        <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
          <?php
          while ($row = $stmt->fetch()) {
            echo
           '<div class="itemBody">
              <div class="itemTitle">'
                .$row['titre'].' ('.$row['typeSujet'].')';
                echo '<div class="itemStatus ';
                    if($row['statut'] == "accepté"){echo 'itemStatusAccepted';}
                    if($row['statut'] == "refusé"){echo 'itemStatusDenied';}
                    if($row['statut'] == "en attente"){echo 'itemStatusPending';}
                    if($row['statut'] == "pris"){echo 'itemStatusTaken';}
                    echo '">
                    '.$row['statut'].'
                </div>';

            echo '
            </div>
            <div class="itemDescription">'.$row['resume'].'</div>
              <div class="itemBottom">
                <div class="itemDate">Date: '.$row['date'].'</div>
                <div class="itemButtons">
                  <button type="submit" name="edit" value="'.$row['id'].'">Modifier</button>
                  <button type="submit" name="delete" value="'.$row['id'].'">Supprimer</button>
                </div>
              </div>
            </div>';
          }
          if($rowCount == 0){
            echo '<div class="noResultsMessage">Vous n\'avez pas encore proposé de sujets.</div>';
          }
          ?>
        </form>
      </div>
    </div>
  </body>
</html>
