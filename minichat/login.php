<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
//$_SESSION['username']=isset($_POST['login']);
//$_SESSION['password']=isset($_POST['mdp']);

try {
    $db = new PDO ('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    print_r("Erreur:" .$e->getMessage());
    }

//SI tu es dans la base de donnée ALORS tu peux accéder
//connecter base de donnée -> lancer requete qui selectionnen la ligne correspondant au pseudo grace a la clause WHERE
//SI mdp correspond a celui enregistré
//oui -> creer $_SESSION['pseudo']=$pseudo,$_SESSION['id']=$donnees['id']
//non -> ERROR
if (isset($_POST['submit'])){
//sanitization
  $options = array(
  'login' => FILTER_SANITIZE_STRING,
  'mdp' => FILTER_SANITIZE_STRING);

  $result = filter_input_array(INPUT_POST, $options);

  if (isset($_POST['login']) && isset($_POST['mdp'])){
    if (!empty($_POST['login']) && !empty($_POST['mdp'])){


    $_SESSION['username'] =$result['login'];
    
      // if(($_SESSION['username'] == "")){
      //   echo "Invalid login";
      // } else {
        $st = $db->query('SELECT COUNT(*) FROM user WHERE prenom="'.$_SESSION['username'].'"')->fetch();
        //echo $_SESSION['username'];
        if ($st['COUNT(*)'] == 1){
          header("Location: index.php");
        }else{
        echo "golmon";
      }
    }
  }
}



?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="stylelogin.css">
    <title>Login to mini chat</title>
  </head>
  <body>
    <form method="post" action="">
      <h1>Login</h1>
      <input type="text" placeholder="Enter your e-mail" name="login" required>
      <h1>Password</h1>
      <input type="password" placeholder="Enter your password" name="mdp" required>
      <input type="submit" name="submit" value="OK">
    </form>
  </body>
</html>
