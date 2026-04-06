<?php
session_start();
if(isset($_POST['ok'])){
   $nom=$_POST['nom'] ??'';
   $motdepasse=$_POST['motdepasse'] ??'';

   if($nom==="admin" and $motdepasse==="1234"){

    session_regenerate_id(true);
    $_SESSION['user']=$nom;
    header('Location: dashboard.php');
    exit;

   }else{
    $message= "Identifiants incorrects.";
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
   <label>NOM:</label>
   <input type="text" name="nom">
   <label>MOT DE PASSE:</label>
   <input type="password" name="motdepasse">
   <button type="submit" name="ok">Se connecter</button>
    </form>
</body>
</html>
<?php
if(!empty($message)) echo "<p style= 'color:red;'>$message</p>";