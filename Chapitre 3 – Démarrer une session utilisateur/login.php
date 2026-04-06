<?php
session_start();
if(isset($_POST["ok"])){
    $nom=trim($_POST['nom']);
if(!empty($nom)){
    $_SESSION['utilisateur']=$nom;
    header('location:profil.php');
    exit;
}else{
    $message="Veuillez entrer votre nom.";
}

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
  <label>NOM</label>
  <input type="text" name="nom">
  <button type="submit" name="ok">Se connecter</button>

    </form>
</body>
</html>
<?php
if(!empty($message)) echo"<p style='color:red;'> $message</p>";?>
                          