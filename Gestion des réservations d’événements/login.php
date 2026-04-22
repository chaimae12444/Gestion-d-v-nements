<?php
require 'config.php';
session_start();
$error = '';
if(isset($_POST['ok'])){
    $email      = trim($_POST['email']);
    $motdepasse = $_POST['motdepasse'];

    if(empty($email) || empty($motdepasse)){
        $error = "Tous les champs sont obligatoires";
    } else {
        $sql  = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($motdepasse, $user['password'])){
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: event.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">

        <?php if($error): ?>
            <p style="color:#ff3b5c; font-size:13px; margin-bottom:6px;">⚠ <?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>EMAIL</label>
            <input type="email" name="email" placeholder="email" value="<?= htmlspecialchars($email ?? '') ?>">

            <label>MOT DE PASSE</label>
            <input type="password" name="motdepasse" placeholder="mot de passe">

            <button type="submit" name="ok">Se connecter</button>
        </form>

    </div>
        <a href="signup.php">cree new account</a>

</body>
</html>