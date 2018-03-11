<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
// $_SESSION['username']=isset($_POST['login']);
//$_SESSION['password']=isset($_POST['mdp']);

try {
    $db = new PDO ('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    print_r("Erreur:" .$e->getMessage());
    }

if (isset($_POST['send'])){

  $option=array(
    'message' => FILTER_SANITIZE_STRING
  );
  $result=filter_input_array(INPUT_POST, $option);
  if(isset($_POST['message'])){
    $message=$result['message'];
    $db->query("INSERT INTO message(messages, user_id) VALUES ('".$message."', 10)");
  }else{
    echo "Message non-send";
  }
  //$_SESSION['message']=$message;
  //header("Location:index.php");
}



?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="stylelogin.css">
    <title>Speak in mini chat</title>
  </head>
  <body>
    <h1>Welcome in hell <!--Nom du mec --></h1>
    <div>
      <section>
        <h5>Send your message</h5>
        <form method="post" action="">
          <input type="text" name="message" placeholder="Type your message..." >
          <input type="submit" name="send" value="Send">
        </form>
        <?php
        $afficher=$db->query("SELECT * FROM message WHERE id = (SELECT max(id) FROM message)");
        $msg=$afficher->fetchAll();
        foreach ($msg as $mess){
          echo $mess['messages'];
        }
          ?>
          <p><?php echo isset($msg['messages']);?></p>
          <?php

         ?>
      </section>
    </div>
    <div>
      <form method="post" action="login.php">
        <input type="submit" name="submit" value="logout">
      </form>
    </div>
  </body>
</html>
