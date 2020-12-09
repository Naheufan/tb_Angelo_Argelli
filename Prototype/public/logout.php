<?php
/*
  Auteur  : Angelo Argelli
  Fichier : logout.php
  Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

  script de destruction de session
*/
session_start();
session_destroy();
header('location: login.php');
?>
