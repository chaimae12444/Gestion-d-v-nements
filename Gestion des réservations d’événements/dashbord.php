<?php
require 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT events.title, events.date_event, events.location, reservations.reservation_date
    FROM reservations
    JOIN events ON reservations.event_id = events.id
    WHERE reservations.user_id = ?
");
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Bienvenue <?= htmlspecialchars($_SESSION['user_name']) ?></h1>

    <h2>Mes réservations</h2>

    <?php if(empty($reservations)): ?>
        <p>Aucune réservation pour le moment.</p>
    <?php else: ?>
        <?php foreach($reservations as $res): ?>
            <div class="card">
                <h3><?= htmlspecialchars($res['title']) ?></h3>
                <p>Date : <?= htmlspecialchars($res['date_event']) ?></p>
                <p>Lieu : <?= htmlspecialchars($res['location']) ?></p>
                <p>Réservé le : <?= htmlspecialchars($res['reservation_date']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="event.php">Retour</a>

</body>
</html>