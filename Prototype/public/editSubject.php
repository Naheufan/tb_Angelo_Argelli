<?php
/*
  Auteur  : Angelo Argelli
  Fichier : editSubject.php
  Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

  page de modification d'un sujet
*/
  //initialisation
  include('functions.php');
  session_start();
  if(!isset($_SESSION['userId'])){
    header('location: login.php');
  }
  if(!isset($_GET['id'])){
    echo '!isset id';
    header('location: index.php');
  }
  $personId = $_SESSION['personId'];
  $personType = $_SESSION['personType'];
  $userType = $_SESSION['userType'];
  $erreurFormulaire = false;
  $bdd = connect();
  // vérification du possesseur du sujet
  if(!isOwner($personId,$_GET['id']) && $userType != "admin"){
    header('location: index.php');
  }
  //collecte du sujet
  else{
    $idSujet = $_GET['id'];
    $sqlQuery=$bdd->prepare("SELECT * FROM v_edit_sujet where id = :idSujet");
    $sqlQuery->bindParam("idSujet", $idSujet, PDO::PARAM_STR);
    $sqlQuery->execute();
    $sujet = $sqlQuery->fetch(PDO::FETCH_ASSOC);
  }
  //UPDATE des modifications
  if(isset($_POST['submit'])){
    if(!isset($_POST['subFiliere']) ||
        !isset($_POST['subType']) ||
        $_POST['subTitle'] == "" ||
        $_POST['subDescription'] ==""){
      $erreurFormulaire = true;
    }
    else{
      if($personType == "professeur"){
        $statut = "accepté";
      }else{
        $statut = "en attente";
      }
      if(!isset($_POST['statut'])){
        $statut = "pris";
      }
      $data = [
          'id' => $_GET['id'],
          'titre' => $_POST['subTitle'],
          'resume' => $_POST['subDescription'],
          'type' => $_POST['subType'],
          'statut' => $statut,
          'filiere' => $_POST['subFiliere'],
      ];
      $sqlQuery = "UPDATE v_edit_sujet SET
      titre = :titre,
      description = :resume,
      type = :type,
      statut = :statut,
      idFiliere = :filiere,
      `date` = NOW()
      WHERE (id = :id);";
      $bdd->prepare($sqlQuery)->execute($data);
      if($_SESSION['from'] == "manganer"){
        header('location: subjectsManager.php');
      }
      else{
        header('location: mySubjects.php');
      }
    }
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sujets de TB - Modifier</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/formSubject.css">
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
      <a href="mySubjects.php"><div class="navbarCell rightCells">Mes Sujets</div></a>
      <a href="documents.php"><div class="navbarCell rightCells">Documents</div></a>
      <?php if($userType == "admin"){echo '<a href="subjectsManager.php"><div class="navbarCell rightCells" >Gestion</div></a>';}?>
    </div>
    <div id="container">
      <div id="containerTitle">Modifier un sujet</div>
      <div id="formPageBody">
        <div id="addSubFormDisclaimer">Modifiez les champs nécéssaires en vous rappelant que votre sujet pourra être visible de tous une fois accepté.</div>
        <div id="formContainer">
          <table>
          <form action="<?=$_SERVER["PHP_SELF"]?>?id=<?=$_GET['id']?>" method="POST">
            <tr>
              <td><label for"statutSujet">Le sujet est toujours disponnible:</label></td>
              <td><input type="checkbox" name="statut" <?php if($sujet['statut'] != "pris"){echo "checked";}?>/></td>
            </tr>
            <tr>
              <td><label for="subFiliere">Le sujet concerne la filière:</label></td>
              <td><select name="subFiliere" required>
                <option value="" disabled>--Selectionner une option--</option>
                <option value="1" <?php if($sujet['idFiliere'] == 1) echo'selected';?>>Informatique de Gestion</option>
                <option value="2" <?php if($sujet['idFiliere'] == 2) echo'selected';?>>Information Documentaire</option>
                <option value="3" <?php if($sujet['idFiliere'] == 3) echo'selected';?>>Économie d'Entreprise</option>
                <option value="4" <?php if($sujet['idFiliere'] == 4) echo'selected';?>>International Business Management</option>
                <option value="0" <?php if($sujet['idFiliere'] == 0) echo'selected';?>>ne concerne pas une filière particulière</option>
              </select></td>
            </tr>
            <tr>
              <td><label for="subType">Type de travail:</label></td>
              <td><select name="subType" required>
                <option value="" disabled>--Selectionner une option--</option>
                <option value="travail pratique" <?php if($sujet['type'] == "travail pratique") echo'selected';?>>Travail Pratique</option>
                <option value="travail de recherche" <?php if($sujet['type'] == "travail de recherche") echo'selected';?>>Travail de Recherche</option>
                <option value="hybride" <?php if($sujet['type'] == "hybride") echo'selected';?>>Travail Hybride</option>
              </select></td>
            </tr>
            <tr>
              <td><label for="subTitle">Titre du sujet:</label></td>
              <td><input type="text" name="subTitle" required value="<?=$sujet['titre']?>"/></td>
                <td><?php if(isset($name_error)) echo $name_error; ?></td>
            </tr>
            <tr>
              <td><label for="subDescription">Description brève du sujet:</label></td>
              <td><textarea type="text" name="subDescription" maxlength="1000" required><?=$sujet['description']?></textarea></td>
            </tr>
            <?php if($erreurFormulaire){echo '<tr><td colspan="2"><span class="error">erreur de formulaire</span></td></tr>';}?>
            <tr>
              <td colspan="2"><input type="submit" name="submit" id="submit" value="Valider"></td>
            </tr>
          </form>
        </table>
        </div>
      </div>
    </div>
  </body>
</html>
