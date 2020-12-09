<?php
  /*
    Auteur  : Angelo Argelli
    Fichier : login.php
    Projet  : Travail de bachelor - Analyse et gestion des sujets de travail de bachelor

    page de connexion
  */
  //initialisation
  include('functions.php');
  session_start();
  $loginError = "";
  //vérification d'envoi du formulaire
  if(isset($_POST['login'])){
    // vérification du contenu des donées
    if(!isset($_POST['username'], $_POST['password'])){
      echo '<span class="error">erreur de formulaire</span>';
    }
    else{
      if($_POST['username'] == "" || $_POST['password'] == "" || !isset($_POST['username'], $_POST['password'])){
        echo '<span class="error">erreur de formulaire</span>';
      }
      else{
        $bdd = connect();
        $username = $_POST['username'];
        $password = $_POST['password'];
        // récupération des données
        $sqlQuery = $bdd->prepare("SELECT * FROM v_user WHERE login = :username");
        $sqlQuery->bindParam("username", $username, PDO::PARAM_STR);
        $sqlQuery->execute();

        $user = $sqlQuery->fetch(PDO::FETCH_ASSOC);
        //vérification de présence d'une correspondance de nom d'utilisateur
        if(!$user){
          $loginError = "Nom d'utilisateur incorrect";
        }
        else{
          //vérification du mot de passe
          if(md5($password) == $user['pwd']){
            //récupération des données de la personne connectée et redirection
            $_SESSION['userId'] = $user['id'];
            $_SESSION['userType'] = $user['type'];
            $sqlQuery=$bdd->prepare("SELECT type, idFiliere, idPersonne FROM v_personne where userId = :userId");
            $sqlQuery->bindParam("userId", $user['id'], PDO::PARAM_STR);
            $sqlQuery->execute();
            $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            $_SESSION['personType'] = $result['type'];
            $_SESSION['idFiliere'] = $result['idFiliere'];
            $_SESSION['personId'] = $result['idPersonne'];
            header('location: index.php');
            exit;
          }
          else{
            $loginError = 'Combinaisons utilisateur/mot de passe incorrecte';
          }
        }
      }
    }
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sujets de TB - Login</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/login.css">
  </head>
  <body>
      <div id="loginContainer">
          <form method="POST" action="">
            <div class="formElement">
              <label>Identifiant</label>
              <input type="text" name="username" required value=""/>
            </div>
            <div class="formElement">
              <label>Mot De Passe</label>
              <input type="password" name="password" required value=""/>
            </div>
            <button id="formSubmit" type="submit" name="login" value="login">Se Connecter</button>
            <?php if($loginError != "")echo '<div class="formElement"><span class="error">'.$loginError.'</span></div>';?>
          </form>
      </div>
  </body>
</html>
