<?php
/*
  Auteur  : Angelo Argelli
  Fichier : addSubject.php
  Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

  page d'ajout d'un nouveau sujet
*/
  // initialisation
  include('functions.php');
  session_start();
  if(!isset($_SESSION['userId'])){
    header('location: login.php');
  }
  $personId = $_SESSION['personId'];
  $userType = $_SESSION['userType'];
  $personType = $_SESSION['personType'];
  $erreurFormulaire = false;
  // vérification forumlaire
  if(isset($_POST['submit'])){
    if(!isset($_POST['subFiliere']) ||
        !isset($_POST['subType']) ||
        $_POST['subTitle'] == "" ||
        $_POST['subDescription'] ==""){
      $erreurFormulaire = true;
    }
    else{
      // INSERT du nouveau sujet
      $bdd = connect();
      if($personType == "professeur"){
        $statut = "accepté";
      }else{
        $statut = "en attente";
      }
      $data = [
          'titre' => $_POST['subTitle'],
          'resume' => $_POST['subDescription'],
          'type' => $_POST['subType'],
          'idPersonne' => $personId,
          'statut' => $statut,
          'filiere' => $_POST['subFiliere'],
      ];
      $sqlQuery = 'INSERT INTO `v_inserting_sujet` (`titre`, `resume`, `date`, `type`, `statut`, `idPersonne`, `idFiliere`)
      VALUES (:titre, :resume, NOW(), :type, :statut, :idPersonne, :filiere);';
      $bdd->prepare($sqlQuery)->execute($data);
      header('location: mySubjects.php');
    }
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sujets de TB - Ajouter</title>
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
      <a href="addSubject.php"><div class="navbarCell rightCells selectedCell">Proposer un Sujet</div></a>
      <a href="mySubjects.php"><div class="navbarCell rightCells">Mes Sujets</div></a>
      <a href="documents.php"><div class="navbarCell rightCells">Documents</div></a>
      <?php if($userType == "admin"){echo '<a href="subjectsManager.php"><div class="navbarCell rightCells" >Gestion</div></a>';}?>
    </div>
    <div id="container">
      <div id="containerTitle">Proposer un sujet</div>
      <div id="formPageBody">
        <div id="addSubFormDisclaimer">Vous vous apprêtez à soumettre une proposition de sujet de travail de bâchelor qui sera visible de tous. Elle sera lue et validée avant d'être disponnible.</div>
        <div id="formContainer">
          <table>
          <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
            <tr>
              <td><label for="subFiliere">Le sujet concerne la filière:</label></td>
              <td><select name="subFiliere" required>
                <option value="" disabled selected>--Selectionner une option--</option>
                <option value="1">Informatique de Gestion</option>
                <option value="2">Information Documentaire</option>
                <option value="3">Économie d'Entreprise</option>
                <option value="4">International Business Management</option>
                <option value="0">ne concerne pas une filière particulière</option>
              </select></td>
            </tr>
            <tr>
              <td><label for="subType">Type de travail:</label></td>
              <td><select name="subType" required>
                <option value="" disabled selected>--Selectionner une option--</option>
                <option value="travail pratique">Travail Pratique</option>
                <option value="travail de recherche">Travail de Recherche</option>
                <option value="hybride">Travail Hybride</option>
              </select></td>
            </tr>
            <tr>
              <td><label for="subTitle">Titre du sujet:</label></td>
              <td><input type="text" name="subTitle" required/></td>
            </tr>
            <tr>
              <td><label for="subDescription">Description brève du sujet:</label></td>
              <td><textarea type="text" name="subDescription" maxlength="1000" required></textarea></td>
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
