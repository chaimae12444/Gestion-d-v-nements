<?php
require 'config.php';
session_start();

$sql = "SELECT * FROM events";
$stmt = $pdo->query($sql);
$listevents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Événements</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>LES EVENMENTS</h1>
        <a href="login.php">login</a>
        <a href="signup.php">signup</a>


    <?php if(isset($_SESSION['user_id'])): ?>
        <div>
            <a href="dashbord.php">Bonjour <?= htmlspecialchars($_SESSION['user_name']) ?> Vos réservations</a>
        </div><br>
    <?php endif; ?>

    <div class="cards-container">
    <?php foreach($listevents as $event): ?>
        <div class="card">
            <h2><?= htmlspecialchars($event['title']) ?></h2>
            <p><?= htmlspecialchars($event['date_event']) ?></p>
            <p><?= htmlspecialchars($event['nbPlaces']) ?> places</p>
            <p><?= htmlspecialchars($event['price']) ?></p>
            <p><?= htmlspecialchars($event['location']) ?></p>
<?php if($event['nbPlaces'] == 0): ?>
    <p class="soldout">SOLD OUT</p>

<?php elseif(isset($_SESSION['user_id'])): ?>
    <form action="booking.php" method="GET">
        <input type="hidden" name="event_id" value="<?= (int)$event['id'] ?>">
        <button type="submit">RÉSERVER</button>
    </form>

<?php else: ?>
    <a href="login.php">Se connecter pour réserver</a>
<?php endif; ?>

        </div>
    <?php endforeach; ?>
</div>
</body>
</html>