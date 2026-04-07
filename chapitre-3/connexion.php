<?php 
$host='localhost';
$dbname='Blogdb';
$username='root';
$password='';
 try{
    $PDO= new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username,$password);
    $PDO->setAttribute(pdo::ATTR_ERRMODE, pdo::ERRMODE_EXCEPTION);
    echo"Connexion réussie à la base $dbname";
 }catch(PDOException $e){
    echo"Erreur de connexion : " . $e->getMessage();
 }

?>