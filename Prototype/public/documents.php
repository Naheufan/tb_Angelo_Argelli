<?php
  /*
    Auteur  : Angelo Argelli
    Fichier : documents.php
    Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

    page d'affichage de la liste des documents à disposition
  */
  //initialisation
  include('functions.php');
  session_start();
  if(!isset($_SESSION['userId'])){
    header('location: login.php');
  }
  $userType = $_SESSION['userType'];
  $filierePersonne = $_SESSION['idFiliere'];
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sujets de TB - Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/documents.css">
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
      <a href="documents.php"><div class="navbarCell rightCells selectedCell">Documents</div></a>
      <?php if($userType == "admin"){echo '<a href="subjectsManager.php"><div class="navbarCell rightCells" >Gestion</div></a>';}?>
    </div>
    <div id="container">
      <div id="containerTitle"> Documents à disposition pour les étudiants</div>
      <div id="documentsBody">
        <ul>
          <h1>Informatique de Gestion</h1>
          <li><a href="https://www.hesge.ch/heg/formation-base/bachelors-science/informatique-gestion/plan-des-modules" target="_blank" rel="noopener noreferrer">Fiche Modulaire</a></li>
          <li><a href="https://www.hesge.ch/heg/etudier-heg/cursus-academique/travaux" target="_blank" rel="noopener noreferrer">Convention du Travail de Bachelor</a></li>
          <h1>Information Documentaire</h1>
          <li><a href="https://www.hesge.ch/heg/formation-base/bachelors-science/information-documentaire/plan-des-modules" target="_blank" rel="noopener noreferrer">Fiche Modulaire</a></li>
          <li><a href="https://www.hesge.ch/heg/etudier-heg/cursus-academique/travaux" target="_blank" rel="noopener noreferrer">Formulaire de proposition de sujet</a></li>
          <li><a href="https://www.hesge.ch/heg/etudier-heg/cursus-academique/travaux" target="_blank" rel="noopener noreferrer">Directives du Travail de Bachelor</a></li>
          <h1>Economie D'Entreprise</h1>
          <li><a href="https://www.hesge.ch/heg/formation-base/bachelors-science/economie-dentreprise/plan-des-modules" target="_blank" rel="noopener noreferrer">Fiche Modulaire</a></li>
          <h1>International Business Management</h1>
          <li><a href="https://www.hesge.ch/heg/formation-base/bachelors-science/international-business-management/plan-des-modules" target="_blank" rel="noopener noreferrer">Fiche Modulaire</a></li>
          <h1>Documents Communs</h1>
          <li><a href="https://intranet.hesge.ch/intranet/enseignement-recherche/formation-de-base" target="_blank" rel="noopener noreferrer">Charte Graphique</a></li>
          <li><a href="https://www.hesge.ch/heg/infotheque/citations-et-references-bibliographiques" target="_blank" rel="noopener noreferrer">Guide de rédaction de bibliographie</a></li>
        </ul>
      </div>
    </div>
  </body>
</html>
