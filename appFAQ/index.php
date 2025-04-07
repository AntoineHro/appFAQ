<?php
session_start();
require_once 'coDB.php';

if (isset($_SESSION['user_id'])) {
    
/* Récupérer les informations de l'utilisateur (pseudo, mail et la ligue) connecté 
Pour ensuite les ressortir dans le html*/
$stmt = $pdo->prepare("SELECT u.pseudo, u.mail, l.lib_ligue 
                       FROM user  u
                       LEFT JOIN ligue  l ON u.id_ligue = l.id_ligue
                       WHERE u.id_user = :id_user");
$stmt->execute([':id_user'  => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
   
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<?php if (isset($_SESSION['user_id'])){?>

    <nav class="navbar">
        <div class="navbar-logo"><p style="text-align: center; color: wheat;">FAQ <br> Enzo // Antoine</p></div> <!--De base c'était le logo mais j'ai vla la flemme de le chercher-->
        <ul class="navbar-links">
            <li><?= htmlspecialchars($user['pseudo']); ?></li>
            <li style="color: rgb(0, 255, 149)">Vous faites partie de la ligue: <br><p style="text-align: center; color:wheat;"><i><?= htmlspecialchars($user['lib_ligue'])?></i></p></li>
            <li><a href="faq.php"><u>Allez voir notre Foire Aux Questions</u></a></li>
            <li><a href="logout.php" style="color: red;"><u>Se déconnecter</u></a></li>
        </ul>
    </nav>

    <h2>Bienvenue, <?=  htmlspecialchars($user['pseudo']); ?> vous êtes bien connecté.</h2>
    
    <p>Votre Email est: 
        <?= htmlspecialchars($user['mail']); ?>
    </p>




<?php exit();} else {?>


<nav class="navbar">
    <div class="navbar-logo">MonSite</div>
    <ul class="navbar-links">
        <li><a href="connexion.php">Se connecter</a></li>
        <li><a href="inscription.php">S'inscrire</a></li>
    </ul>
</nav>
    
<p style="color: gray;">Vous n'êtes pas connecté(e), veuillez vous inscrire ou vous connecter pour pouvoir accéder à notre Foire aux Questions</p>


<?php }?>
</body>
</html>
