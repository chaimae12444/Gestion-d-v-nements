<?php
require 'config.php';
session_start();

$errors = [];

if(isset($_POST['ok'])){
    $nom       = trim($_POST['nom']);
    $email     = trim($_POST['email']);
    $motdepasse  = $_POST['motdepasse'];
    $motdepasse2 = $_POST['motdepasse2'];

    if(empty($nom) || empty($email) || empty($motdepasse) || empty($motdepasse2)){
        $errors[] = "Tous les champs sont obligatoires";
    }
    if(strlen($motdepasse) < 8){
        $errors[] = "Le mot de passe doit avoir au moins 8 caractères";
    }
    if($motdepasse !== $motdepasse2){
        $errors[] = "Les mots de passe ne correspondent pas";
    }
    if(!preg_match('/[A-Z]/', $motdepasse) || !preg_match('/[0-9]/', $motdepasse)){
        $errors[] = "Le mot de passe doit contenir au moins une majuscule et un chiffre";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Email invalide";
    }
    if(empty($errors)){
        $sql = "INSERT INTO users (name, email, password) VALUES(:nom, :email, :motdepasse)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom'        => $nom,
            ':email'      => $email,
            ':motdepasse' => password_hash($motdepasse, PASSWORD_DEFAULT)
        ]);

        header('Location: login.php?msg=success');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">

        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $error): ?>
                <p style="color:#ff3b5c; font-size:13px; margin-bottom:6px;">⚠ <?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="POST">
            <label>NAME:</label>
            <input type="text" name="nom" placeholder="nom" value="<?= htmlspecialchars($nom ?? '') ?>">

            <label>EMAIL:</label>
            <input type="email" name="email" placeholder="email" value="<?= htmlspecialchars($email ?? '') ?>">

            <label>MOT DE PASSE</label>
            <input type="password" name="motdepasse" placeholder="motdepasse">

            <label>CONFIRMATION MOT DE PASSE</label>
            <input type="password" name="motdepasse2" placeholder="motdepasse">

            <button type="submit" name="ok">S'inscrire</button>
        </form>

    </div>
    <a href="login.php">login</a>
</body>
</html>