<?php
session_start();
include 'coDB.php';

if (isset($_SESSION['user_id'])) {
    
/* Récupérer les informations de l'utilisateur (pseudo, mail et la ligue) connecté 
Pour ensuite les ressortir dans le html*/
$stmt = $pdo->prepare("SELECT u.pseudo, u.mail, l.lib_ligue 
                       FROM user  u
                       INNER JOIN ligue l ON u.id_ligue = l.id_ligue
                       WHERE u.id_user = :id_user");
$stmt->execute([':id_user'  => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
   
}

$tz = new DateTimeZone('Europe/Paris');
$dt1 = new DateTime('now', $tz );

// recuperation des infoirmations de l'utilisateur
$stmt = $pdo->prepare("SELECT user.id_user, user.pseudo, dateNaissance, lib_usertype, lib_ligue FROM user, usertype, ligue
                              where user.id_usertype = usertype.id_usertype
                              AND user.id_ligue = ligue.id_ligue");
$stmt->execute();
$users = $stmt->fetchALL(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>calcul de l'age</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])){?>

    <nav class="navbar">
        <div class="navbar-logo"><p>appFAQ</p></div> <!--De base c'était le logo mais j'ai vla la flemme de le chercher-->
        <ul class="navbar-links">
            <li><?= $user['pseudo']; ?></li>
            <li><a href="index.php">Revenir à l'accueil</a></li>
            <li><a href="faq.php"><u>Allez voir notre Foire Aux Questions</u></a></li>
            <li><a href="logout.php" style="color: red;"><u>Se déconnecter</u></a></li>
        </ul>
    </nav>

    <h1>Voici la liste des utilisateurs avec leurs ages</h1>
    
<table border="1">
    <tr>
        <th>ID utilisateur</th>
        <th>Pseudo Utilisateur</th>
        <th>Age utilsiateur</th>
        <th>Type utilisateur</th>
        <th>Ligue de l'utilisateur</th>
    </tr>
    <?php
    echo "<tr>";
    foreach($users as $e){

        $dateNaissanceUsers = $e['dateNaissance'];
        $dt2 = new DateTime($dateNaissanceUsers);
        $di = $dt2->diff($dt1); 

        echo "<td>" . $e['id_user'] . "</td><td>" . $e['pseudo'] . "</td><td>" . $di->format('%y an(s)') . "</td><td>" .  $e['lib_usertype'] . "</td><td>" . $e['lib_ligue'] . "</td>" ;
        echo "</tr>";
    } 
    ?>
</table>

<?php exit();} else {
    header('Location: index.php');
}?>
</body>
</html>