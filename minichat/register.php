<?php
//
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//session_start();


try {
    $db = new PDO ('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    print_r("Erreur:" .$e->getMessage());
    }



  //$register=isset($_POST['register']);
  //$sanitize=filter_var(['register'], FILTER_SANITIZE_STRING);
  //$rep=$db->query('SELECT id, username, email, password FROM user');
  //$varrep=$rep->fetch();
if (isset($_POST['register'])){
  $options = array(
  'username' => FILTER_SANITIZE_STRING,
  'email' => FILTER_VALIDATE_EMAIL,
  'password' => FILTER_SANITIZE_STRING,
  'password2' => FILTER_SANITIZE_STRING);

$result = filter_input_array(INPUT_POST, $options);

  if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])){

    $username=htmlspecialchars($result['username']);
    $email=htmlspecialchars($result['email']);
    $password=htmlspecialchars($result['password']);
    $password2=htmlspecialchars($result['password2']);
    //crypte le mdp
    $hash=password_hash($password, PASSWORD_DEFAULT);
    //compare les mdp dans les 2 champs
      if(password_verify($password2, $hash)){
        $db->query("INSERT INTO user(prenom, email, password) VALUES ('".$username."', '".$email."', '".$hash."')");
      }else{
        echo "Invalid password";
        }
        //pas d'erreur a cet endroit
      $_SESSION['username']=$username;
      $_SESSION['email']=$email;
      $_SESSION['password']=$password;
      $_SESSION['password2']=$password2;

      header("Location:login.php");
  }
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styleregister.css">
    <title>Register to mini chat</title>
  </head>
  <body>
    <h1>Registration required</h1>
    <form method="post" action="">

      <h2>Username</h2>
      <input type="text" placeholder="No space" name="username" required>

      <h2>e-Mail</h2>
      <input type="text" placeholder="e-mail" name="email" required>

      <h2>Password</h2>
      <input type="password" placeholder="Enter your password" name="password" required>

      <h2>Confirm password</h2>
      <input type="password" placeholder="Confirm your password" name="password2" required>

      <input type="submit" name="register" value="OK">
    </form>
  </body>
</html>
