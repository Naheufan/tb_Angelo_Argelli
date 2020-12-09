<?php
/*
  Auteur  : Angelo Argelli
  Fichier : index.php
  Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

  page d'accueil et principale, affiche la liste des sujets proposés
*/
  include('functions.php');
  session_start();
  if(!isset($_SESSION['userId'])){
    header('location: login.php');
  }
  $bdd = connect();
  $userType = $_SESSION['userType'];
  $userId = $_SESSION['userId'];
  if($userType == "user"){
    $personType = $_SESSION['personType'];
    $filierePersonne = $_SESSION['idFiliere'];
  }else{
    $personType = "";
    $filierePersonne = 1;
  }
  /*définition du champ de recherche*/
  if(!isset($_GET['filiere'])){

    $filiere = $filierePersonne;
  }
  else{
    $filiere = $_GET['filiere'];
  }
  $sqlQuery="SELECT * FROM v_sujet where idFiliere = $filiere ";
  /* application des filtres de recherche*/
  if(isset($_GET['rType']) && $_GET['rType'] != "all"){
    $rType = $_GET['rType'];
    $sqlQuery .= "AND typeSujet = \"$rType\" ";
  }
  if($personType != "étudiant"){
    if(isset($_GET['rStatus']) && $_GET['rStatus'] != "all"){
      $rStatus = $_GET['rStatus'];
      $sqlQuery .= "AND statut = \"$rStatus\" ";
    }
  }
  if(isset($_GET['rText']) && $_GET['rText'] != ""){
    $rText = $_GET['rText'];
    $sqlQuery .= "AND titre LIKE ".'"%'.$rText.'%"'." OR 'resume' LIKE  ".'"%'.$rText.'%" ';
  }
  if($personType != "")                                     //les professeurs ne voient que les sujets des étudiants et vice-versa
    $sqlQuery .= " and typePersonne <> \"$personType\"";
  if($personType == "étudiant")                             // les étudiants ne voyent que les projets acceptés par les admins (donc pas ceux en attente, pris ou refusés)
    $sqlQuery .= ' and statut = "accepté"';
  $stmt = $bdd->query($sqlQuery);
  $rowCount = $stmt->rowCount();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sujets de TB - Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/searchBar.css">
  </head>
  <body>
    <div id="navbar">
      <a href="<?php echo $_SERVER['PHP_SELF'].'?filiere=1';?>"><div class="navbarCell<?php if($filiere==1){echo" selectedCell";}?>">IG <div class="tooltip">Informatique de Gestion</div></div></a>
      <a href="<?php echo $_SERVER['PHP_SELF'].'?filiere=2';?>"><div class="navbarCell<?php if($filiere==2){echo" selectedCell";}?>">ID <div class="tooltip">Information Documentaire</div></div></a>
      <a href="<?php echo $_SERVER['PHP_SELF'].'?filiere=3';?>"><div class="navbarCell<?php if($filiere==3){echo" selectedCell";}?>">EE <div class="tooltip">Économie d'Entreprise</div></div></a>
      <a href="<?php echo $_SERVER['PHP_SELF'].'?filiere=4';?>"><div class="navbarCell<?php if($filiere==4){echo" selectedCell";}?>">IBM<div class="tooltip">International Business Management</div></div></a>
      <a href="<?php echo $_SERVER['PHP_SELF'].'?filiere=0';?>"><div class="navbarCell<?php if($filiere==0){echo" selectedCell";}?>">Divers</div></a>
      <a href="logout.php"><div class="navbarCell rightCells"> X <div class="tooltip">Déconnexion</div></div></a>
      <a href="addSubject.php"><div class="navbarCell rightCells">Proposer un Sujet</div></a>
      <a href="mySubjects.php"><div class="navbarCell rightCells">Mes Sujets</div></a>
      <a href="documents.php"><div class="navbarCell rightCells">Documents</div></a>
      <?php if($userType == "admin"){echo '<a href="subjectsManager.php"><div class="navbarCell rightCells" >Gestion</div></a>';}?>
    </div>
    <div id="container">
      <div id="containerTitle"> Sujets de Travail de Bachelor proposés</div>
      <div id="searchBar">
        <form method="get" action="">
          <input hidden name="filiere" value="<?= $_GET['filiere']?>"/>
          <table>
            <tr>
                <td><label for="rType">Type:</label></td>
                <td><select name="rType">
                  <option <?php if(!isset($_GET['rType']) || $_GET['rType'] == "all") echo 'selected';?> value="all">Tous les types</option>
                  <option <?php if(isset($_GET['rType']) && $_GET['rType'] == "travail pratique") echo 'selected';?> value="travail pratique">Travail Pratique</option>
                  <option <?php if(isset($_GET['rType']) && $_GET['rType'] == "travail de recherche") echo 'selected';?> value="travail de recherche">Travail de Recherche</option>
                  <option <?php if(isset($_GET['rType']) && $_GET['rType'] == "travail hybride") echo 'selected';?> value="hybride">Travail Hybride</option>
                </select></td>
                <td><label for="rText">Rechercher:</label></td>
                <td><input type="text" name="rText" value="<?php if(isset($_GET['rText'])) echo $_GET['rText'];?>"/></td>
            </tr>
            <tr>
              <td><?php if($personType != "étudiant"){ echo '<label for="rStatus">Statut:</label></td>
              <td><select name="rStatus">
                <option '; if(!isset($_GET['rStatus']) || $_GET['rStatus'] == "all") echo 'selected'; echo ' value="all">Tous les statuts</option>
                <option '; if(isset($_GET['rStatus']) && $_GET['rStatus'] == "en attente") echo 'selected'; echo ' value="en attente">En attente</option>
                <option '; if(isset($_GET['rStatus']) && $_GET['rStatus'] == "accepté") echo 'selected'; echo ' value="accepté">Acceptés</option>
                <option '; if(isset($_GET['rStatus']) && $_GET['rStatus'] == "refusé") echo 'selected'; echo ' value="refusé">Refusés</option>
                <option '; if(isset($_GET['rStatus']) && $_GET['rStatus'] == "pris") echo 'selected'; echo ' value="pris">Pris</option>
              </select></td>';
            }?>
              <td colspan="2" class="searchTd"><button type="submit" name"search">Rechercher</button></td>
            </tr>
          </table>
        </form>
      </div>
      <div id="itemListBody">
        <?php
        while ($row = $stmt->fetch()) {
          echo
         '<div class="itemBody">
            <div class="itemTitle">'
              .$row['titre'].' ('.$row['typeSujet'].')';
              if($personType != "étudiant"){
              echo '<div class="itemStatus ';
                  if($row['statut'] == "accepté"){echo 'itemStatusAccepted';}
                  if($row['statut'] == "refusé"){echo 'itemStatusDenied';}
                  if($row['statut'] == "en attente"){echo 'itemStatusPending';}
                  if($row['statut'] == "pris"){echo 'itemStatusTaken';}
                  echo '">
                  '.$row['statut'].'
              </div>';
            }
          echo '
          </div>
          <div class="itemDescription">'.$row['resume'].'</div>
            <div class="itemBottom">
              <div class="itemDate">Date: '.$row['date'].'</div>
              <div class="itemOwner">Proposé par: '.$row['nomPersonne'].
                ' <a href="mailto:'.$row['contactPersonne'].'"><span class="contact">✉ Contacter</span></a>
              </div>
            </div>
          </div>';
        }
        if($rowCount == 0){
          echo '<div class="noResultsMessage">Aucun sujet trouvé pour cette filière.</div>';
        }
        ?>
      </div>
      <?php
        if($rowCount > 10){
          echo '<div id="pageNumbers"><< Page '. 1 .' >></div>';
        }
      ?>
    </div>
  </body>
</html>
