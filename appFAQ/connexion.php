<?php
session_start();
include 'coDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM user WHERE pseudo = :pseudo");
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($user && password_verify($pass, $user['mdp'])) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['mail'] = $user['mail'];
        $_SESSION['id_usertype'] = $user['id_usertype'];
        $_SESSION['id_ligue'] = $user['id_ligue'];

        header("Location: index.php");
        exit();
    } else {
        $error = "Pseudo ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/connexion.css">
</head>
<body>

<div class="index">
    <form action="" method="post"> 

        <h1>Connexion</h1>

        <h2><a href="inscription.php">S'inscrire ?</a></h2>

        <label for="pseudo">Pseudo
            <br>
            <input type="text" name="pseudo" placeholder="Rentrez votre pseudo." required>
        </label>

        <br>
        <br>

        <label for="password">Mot de passe
            <br>
            <input type="password" name="password" id="password" placeholder="Veuillez saisir un mot de passe" required>
        </label>
        <br>
        <br>
        <h4><a href="index.php">Revenir à l'accueil</a></h4>
        
        <button type="submit">Envoyer</button>

    </form>


</div>

</body>
</html>
