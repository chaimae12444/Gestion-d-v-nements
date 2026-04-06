<?php
$erreurs=[];
$nom = $email="";

if(isset($_POST['submit'])){
    $nom=trim($_POST['nom']);

      $email=trim($_POST['email']);

      if(empty($nom)){
        $erreurs[]= "Le nom est obligatoire";
      }
        if(empty($email)){
            $erreurs[]="email est obligatoire";
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $erreurs[]="L'email n'est pas valide";
        }
        if(empty($erreurs)){
          echo  "<p style='color:green;'>Formulaire envoyé avec succès !<p>";
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
    <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>" ><br>
    <label>EMAIL:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
    <button type="submit" name="submit">ENVOYER</button>
     
</form>
<?php
if(!empty($erreurs)){
    echo " <ul style='color:red'>";
    foreach($erreurs as $eror){
        echo "<li>$eror</li>";

    }
    echo"</ul>";
}
?>


</body>
</html>
