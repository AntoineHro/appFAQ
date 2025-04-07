<?php
/*
Bon ici c'est juste le script de connexion à la base de donnée (le meme que celui du cours) 
et à la fin un message d'erreur s'affiche si la connexion a echoué. 
Mais ici y a pas de raison que ça marche pas
*/
$host = 'localhost';
$dbname = 'appFAQ';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur lors de la connexion SQL : " . $e->getMessage());
}
?>