<?php
/*
  Auteur  : Angelo Argelli
  Fichier : subjectsManager.php
  Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

  page d'administration des sujets proposés
*/
  //initialisation
  include('functions.php');
  session_start();
  if(!isset($_SESSION['userId'])){
    header('location: login.php');
  }
  if($_SESSION['userType'] != "admin"){
    header('location: mySubjects.php');
  }
  $bdd = connect();
  $userType = $_SESSION['userType'];
  $userId = $_SESSION['userId'];
  $personType = $_SESSION['personType'];
  $filiere = $_SESSION['idFiliere'];
  $personId = $_SESSION['personId'];
  //traitement des boutons
  if($userType == "admin")
  {
    if(isset($_POST['edit'])){
      $_SESSION['from'] = "manganer";
      header('location: editSubject.php?id='.$_POST['edit']);
    }
    if(isset($_POST['delete'])){
      $subjectId = $_POST['delete'];
      $stmt = $bdd->prepare("DELETE FROM v_edit_sujet WHERE id = $subjectId");
      $stmt->execute();
    }
    $statusChange = FALSE;
    $id = 0;
    if(isset($_POST['take'])){
      $id = $_POST['take'];
      $status = "pris";
      $statusChange = TRUE;
    }
    if(isset($_POST['accept'])){
      $id = $_POST['accept'];
      $status = "accepté";
      $statusChange = TRUE;
    }
    if(isset($_POST['suspend'])){
      $id = $_POST['suspend'];
      $status = "en attente";
      $statusChange = TRUE;
    }
    if(isset($_POST['refuse'])){
      $id = $_POST['refuse'];
      $status = "refusé";
      $statusChange = TRUE;
    }
    if($statusChange){
      $data = [
          'id' => $id,
          'statut' => $status,
      ];
      $sqlQuery = "UPDATE v_edit_sujet SET
      statut = :statut
      WHERE (id = :id);";
      $bdd->prepare($sqlQuery)->execute($data);
    }
  }
  //définition du champ de recherche
  $sqlQuery = "SELECT * FROM v_sujet WHERE 1 = 1 ";
  //application des filtres de recherche
  if(isset($_GET['rFiliere']) && $_GET['rFiliere'] != "all"){
    $rFiliere = $_GET['rFiliere'];
    $sqlQuery .= "AND idFiliere = \"$rFiliere\" ";
  }
  if(isset($_GET['rType']) && $_GET['rType'] != "all"){
    $rType = $_GET['rType'];
    $sqlQuery .= "AND typeSujet = \"$rType\" ";
  }
  if(isset($_GET['rStatus']) && $_GET['rStatus'] != "all"){
    $rStatus = $_GET['rStatus'];
    $sqlQuery .= "AND statut = \"$rStatus\" ";
  }
  if(!isset($_GET['rStatus'])){
    $rStatus = 'en attente';
    $sqlQuery .= "AND statut = \"$rStatus\" ";
  }
  if(isset($_GET['rText']) && $_GET['rText'] != ""){
    $rText = $_GET['rText'];
    $sqlQuery .= "AND titre LIKE ".'"%'.$rText.'%"'." OR 'resume' LIKE  ".'"%'.$rText.'%" ';
  }
  $stmt=$bdd->prepare($sqlQuery);
  $stmt->execute();
  $rowCount = $stmt->rowCount();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sujets de TB - Gestion</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/searchBar.css">
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
      <a href="mySubjects.php"><div class="navbarCell rightCells" >Mes Sujets</div></a>
      <a href="documents.php"><div class="navbarCell rightCells">Documents</div></a>
      <a href="subjectsManager.php"><div class="navbarCell rightCells selectedCell" >Gestion</div></a>
    </div>
    <div id="container">
      <div id="containerTitle">Gestion des sujets</div>
      <div id="searchBar">
        <form method="get" action="<?= $_SERVER['PHP_SELF']?>">
          <table>
            <tr>
              <td><label for="rFiliere">Filière:</label></td>
              <td><select name="rFiliere">
                <option <?php if(!isset($_GET['rFiliere']) || $_GET['rFiliere'] == "all") echo 'selected';?> value="all">Toutes les filières</option>
                <option <?php if(isset($_GET['rFiliere']) && $_GET['rFiliere'] == "1") echo 'selected';?> value="1">Informatique de Gestion</option>
                <option <?php if(isset($_GET['rFiliere']) && $_GET['rFiliere'] == "2") echo 'selected';?> value="2">Information Documentaire</option>
                <option <?php if(isset($_GET['rFiliere']) && $_GET['rFiliere'] == "3") echo 'selected';?> value="3">Économie d'Entreprise</option>
                <option <?php if(isset($_GET['rFiliere']) && $_GET['rFiliere'] == "4") echo 'selected';?> value="4">International Business Management</option>
                <option <?php if(isset($_GET['rFiliere']) && $_GET['rFiliere'] == "5") echo 'selected';?> value="0">ne concerne pas une filière particulière</option>
              </select></td>
                <td><label for="rText">Rechercher:</label></td>
                <td><input type="text" name="rText" value="<?php if(isset($_GET['rText'])) echo $_GET['rText'];?>"/></td>
            </tr>
            <tr>
              <td><label for="rType">Type:</label></td>
              <td><select name="rType">
                <option <?php if(!isset($_GET['rType']) || $_GET['rType'] == "all") echo 'selected';?> value="all">Tous les types</option>
                <option <?php if(isset($_GET['rType']) && $_GET['rType'] == "travail pratique") echo 'selected';?> value="travail pratique">Travail Pratique</option>
                <option <?php if(isset($_GET['rType']) && $_GET['rType'] == "travail de recherche") echo 'selected';?> value="travail de recherche">Travail de Recherche</option>
                <option <?php if(isset($_GET['rType']) && $_GET['rType'] == "travail hybride") echo 'selected';?> value="hybride">Travail Hybride</option>
              </select></td>
            </tr>
            <tr>
              <td><label for="rStatus">Statut:</label></td>
              <td><select name="rStatus">
                <option <?php if(isset($_GET['rStatus']) && $_GET['rStatus'] == "all") echo 'selected';?> value="all">Tous les statuts</option>
                <option <?php if(!isset($_GET['rStatus']) || $_GET['rStatus'] == "en attente") echo 'selected';?> value="en attente">En attente</option>
                <option <?php if(isset($_GET['rStatus']) && $_GET['rStatus'] == "accepté") echo 'selected';?> value="accepté">Acceptés</option>
                <option <?php if(isset($_GET['rStatus']) && $_GET['rStatus'] == "refusé") echo 'selected';?> value="refusé">Refusés</option>
                <option <?php if(isset($_GET['rStatus']) && $_GET['rStatus'] == "pris") echo 'selected';?> value="pris">Pris</option>
              </select></td>
              <td colspan="2" class="searchTd"><button type="submit" name"search">Rechercher</button></td>
            </tr>
          </table>
        </form>
      </div>
      <div id="itemListBody">
        <form method="post" action="">
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
                <div class="itemButtons">
                Proposé par: '.$row['nomPersonne'].'
                <button ';if($row['statut'] == "accepté"){echo 'disabled ';} echo 'class="itemStatusAccepted" type="submit" name="accept" value="'.$row['id'].'">Accepter</button>
                <button ';if($row['statut'] == "refusé"){echo 'disabled ';} echo 'class="itemStatusDenied" type="submit" name="refuse" value="'.$row['id'].'">Refuser</button>
                <button ';if($row['statut'] == "en attente"){echo 'disabled ';}echo 'class="itemStatusPending" type="submit" name="suspend" value="'.$row['id'].'">Suspendre</button>
                <button ';if($row['statut'] == "pris"){echo 'disabled ';}echo 'class="itemStatusTaken" type="submit" name="take" value="'.$row['id'].'">Réserver</button> |
                <button type="submit" name="edit" value="'.$row['id'].'">Modifier</button>
                <button type="submit" name="delete" value="'.$row['id'].'">Supprimer</button>
                </div>
              </div>
            </div>';
          }
          if($rowCount == 0){
            echo '<div class="noResultsMessage">Aucun sujet trouvé pour cette filière.</div>';
          }
          ?>
        </form>
      </div>
    </div>
  </body>
</html>
