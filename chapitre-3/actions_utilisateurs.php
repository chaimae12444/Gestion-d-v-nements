<?php
require 'connexion.php';

try {
    $stmt = $PDO->prepare("INSERT INTO Utilisateur (nom, email) VALUES (:nom, :email)");
    $stmt->execute([
        'nom' => 'Charlie',
        'email' => 'charlie@test.com'
    ]);
    echo "Utilisateur ajouté avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$stmt = $PDO->prepare("UPDATE Utilisateur SET email = :email WHERE id = :id");
$stmt->execute([
    'email' => 'charlie.new@test.com',
    'id' => 3
]);
echo "Utilisateur mis à jour.";
$stmt = $PDO->prepare("DELETE FROM Utilisateur WHERE id = :id");
$stmt->execute(['id' => 3]);
echo "Utilisateur supprimé.";
echo $stmt->rowCount() . " ligne(s) affectée(s).";
