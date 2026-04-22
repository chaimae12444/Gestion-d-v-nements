<?php
require 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if(!isset($_GET['event_id'])){
    header("Location: event.php");
    exit;
}

$user_id  = $_SESSION['user_id'];
$event_id = (int)$_GET['event_id'];

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$event){
    header("Location: event.php");
    exit;
}

$error = '';

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT nbPlaces FROM events WHERE id = ? FOR UPDATE");
    $stmt->execute([$event_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['nbPlaces'] <= 0){
        $error = "SOLD OUT";
        $pdo->rollBack();
    } else {
       
        $check = $pdo->prepare("SELECT id FROM reservations WHERE user_id = ? AND event_id = ?");
        $check->execute([$user_id, $event_id]);
        if($check->fetch()){
            $error = "Vous avez déjà réservé cet événement.";
            $pdo->rollBack();
        } else {
            $pdo->prepare("INSERT INTO reservations (user_id, event_id) VALUES (?, ?)")
                ->execute([$user_id, $event_id]);

            $pdo->prepare("UPDATE events SET nbPlaces = nbPlaces - 1 WHERE id = ?")
                ->execute([$event_id]);

            $pdo->commit();

     
            $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
            $stmt->execute([$event_id]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
} catch(Exception $e){
    $pdo->rollBack();
    $error = "Une erreur est survenue. Veuillez réessayer.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php if($error): ?>
        <div class="card">
            <p style="color:#ff3b5c;"> <?= htmlspecialchars($error) ?></p>
            <a href="event.php">Retour</a>
        </div>
    <?php else: ?>
        <div class="card">
            <h3>Réservation réussie</h3>
            <h2><?= htmlspecialchars($event['title']) ?></h2>
            <p>Date : <?= htmlspecialchars($event['date_event']) ?></p>
            <p>Places restantes : <?= (int)$event['nbPlaces'] ?></p>
            <p>Prix : <?= htmlspecialchars($event['price']) ?></p>
            <p>Lieu : <?= htmlspecialchars($event['location']) ?></p>
            <a href="event.php">⬅ Retour</a>
        </div>
    <?php endif; ?>

</body>
</html>