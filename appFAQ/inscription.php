<?php
session_start();
require_once 'coDB.php';

$message = '';

/* Récupération des ligues pour le menu déroulant 
(j'ai du faire avec un where sinon ce con me sortait 'toute les ligues' dans la liste pour selectioner la ligue) 
*/
$ligues = $pdo->query("SELECT lib_ligue FROM ligue WHERE lib_ligue IN ('Football', 'Basketball', 'Volleyball', 'Handball') ORDER BY lib_ligue ASC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && !empty($_POST['pseudo']) 
    && !empty($_POST['email']) 
    && !empty($_POST['password']) 
    && !empty($_POST['ligue'])) {

    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $ligue = $_POST['ligue'];

    // Récupérer l'ID de la ligue
    $stmt = $pdo->prepare("SELECT id_ligue FROM ligue WHERE lib_ligue = :ligue");
    $stmt->bindParam(':ligue', $ligue);
    $stmt->execute();
    $ligueData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ligueData) {
        $message = "Ligue invalide.";
    } else {
        $id_ligue = $ligueData['id_ligue'];
        $id_usertype = 1; /* on applique la value 1 pcq c'est l'id de l'utilisateur lambda (juste poser une question)*/

        /* Vérifier si le pseudo ou mail existe déjà */
        $stmt = $pdo->prepare("SELECT * FROM user WHERE pseudo = :pseudo OR mail = :email");
        $stmt->execute(['pseudo' => $pseudo, 'email' => $email]);

        if ($stmt->rowCount() > 0) {
            $message = "Pseudo ou e-mail déjà utilisé.";
        } else {

            $stmt = $pdo->prepare("INSERT INTO user (pseudo, mail, mdp, id_usertype, id_ligue) VALUES (:pseudo, :email, :password, :usertype, :ligue)");
            $nb = $stmt->execute([
                'pseudo' => $pseudo,
                'email' => $email,
                ':password' => $pass,
                ':usertype' => $id_usertype,
                ':ligue' => $id_ligue
            ]);

            if ($nb == 1) {
                $message = "Utilisateur enregistré avec succès.";
            } else {
                $message = "Erreur lors de l'enregistrement.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/inscription.css">
</head>
<body>

<div class="index">        
    <form action="" method="post"> 
        <h1>Inscription</h1>
        <h2><a href="connexion.php">Se connecter</a></h2>

        <?php if (!empty($message)): ?>
            <p style="color: <?= str_contains($message, 'succès') ? 'green' : 'red' ?>;">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <label for="pseudo">Pseudo<br>
            <input type="text" name="pseudo" placeholder="Choisissez un pseudo." required>
        </label>
        <br>
        <br>

        <label for="email">Email<br>
            <input type="email" name="email" placeholder="Rentrez une adresse Mail." required>
        </label>
        <br>
        <br>

        <label for="password">Mot de passe<br>
            <input type="password" name="password" id="password" placeholder="min. 7 caractères" minlength="7" required>
        </label>
        <br>
        <br>

        <label for="ligue">Sélectionnez une ligue :
            <select name="ligue" id="ligue" required>
                    <?php foreach ($ligues as $l): ?>
                <option value="<?= $l['lib_ligue'] ?>">
                <?= $l['lib_ligue'] ?>
                </option>
        <?php endforeach; ?>
            </select>
        </label>
        <br>
        <br>
        <h4>
        
        <a href="index.php">Revenir à l'accueil</a></h4>

        <button type="submit">Envoyer</button>
    </form>
</div>

</body>
</html>
