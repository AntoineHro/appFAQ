<?php
session_start();
require_once 'coDB.php';

/* Vérification de la session de l'utilisateur */
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Récupération des informations de l'utilisateur */
$stmt = $pdo->prepare("SELECT id_usertype, id_ligue, pseudo FROM user WHERE id_user = :id_user");
$stmt->execute(['id_user' => $user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    die("Utilisateur introuvable.");
}

$id_usertype = $userData['id_usertype'];
$user_ligue = $userData['id_ligue'];
$_SESSION['pseudo'] = $userData['pseudo'];
$_SESSION['usertype_id'] = $id_usertype;

$isUser = ($id_usertype == 1);
$isAdmin = ($id_usertype == 2);
$isSuperAdmin = ($id_usertype == 3);

/* Ajouter une question */
if (isset($_POST['add_question'])) {
    $question = $_POST['question'];

    if (!empty($question)) {
        $stmt = $pdo->prepare("INSERT INTO faq (id_user, question, reponse, dat_question) VALUES (:id_user, :question, '', NOW())");
        $stmt->execute([
            'id_user' => $user_id,
            'question' => $question,
        ]);
    }
}

/* Répondre à une question */
if (isset($_POST['reply_question']) && ($isAdmin || $isSuperAdmin)) {
    $id_faq = $_POST['question_id'];
    $reponse = $_POST['reponse'];

    $stmt = $pdo->prepare("SELECT u.id_ligue FROM faq f JOIN user u ON f.id_user = u.id_user WHERE f.id_faq = :id_faq");
    $stmt->execute(['id_faq' => $id_faq]);
    $questionUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($reponse) && $questionUser &&
        ($isSuperAdmin || $questionUser['id_ligue'] == $user_ligue)) {
        $stmt = $pdo->prepare("UPDATE faq SET reponse = :reponse, dat_reponse = NOW() WHERE id_faq = :id_faq");
        $stmt->execute(['reponse' => $reponse, 'id_faq' => $id_faq]);
    }
}

/* Supprimer une question */
if (isset($_POST['delete_question']) && ($isAdmin || $isSuperAdmin)) {
    $id_faq = $_POST['question_id'];

    $stmt = $pdo->prepare("SELECT u.id_ligue FROM faq f 
                           JOIN user u ON f.id_user = u.id_user 
                           WHERE f.id_faq = :id_faq");
    $stmt->execute(['id_faq' => $id_faq]);
    $questionUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($questionUser && ($isSuperAdmin || $questionUser['id_ligue'] == $user_ligue)) {
        $stmt = $pdo->prepare("DELETE FROM faq WHERE id_faq = :id_faq");
        $stmt->execute(['id_faq' => $id_faq]);
    }
}

/* Modifier une question */
if (isset($_POST['edit_question']) && !empty($_POST['new_question']) && ($isAdmin || $isSuperAdmin)) {
    $id_faq = $_POST['question_id'];
    $new_question = $_POST['new_question'];

    $stmt = $pdo->prepare("SELECT u.id_ligue FROM faq f 
                           JOIN user u ON f.id_user = u.id_user 
                           WHERE f.id_faq = :id_faq");
    $stmt->execute(['id_faq' => $id_faq]);
    $questionUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($questionUser && ($isSuperAdmin || $questionUser['id_ligue'] == $user_ligue)) {
        $stmt = $pdo->prepare("UPDATE faq SET question = :new_question WHERE id_faq = :id_faq");
        $stmt->execute(['new_question' => $new_question, 'id_faq' => $id_faq]);
    }
}

/* Récupération des questions */
if ($isSuperAdmin) {
    $questions = $pdo->query("SELECT f.id_faq, f.question, f.reponse, f.dat_question, f.dat_reponse, u.pseudo, l.lib_ligue, u.id_ligue
                              FROM faq f
                              JOIN user u ON f.id_user = u.id_user
                              JOIN ligue l ON u.id_ligue = l.id_ligue
                              ORDER BY f.dat_question DESC")->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT f.id_faq, f.question, f.reponse, f.dat_question, f.dat_reponse, u.pseudo, l.lib_ligue, u.id_ligue
                           FROM faq f
                           JOIN user u ON f.id_user = u.id_user
                           JOIN ligue l ON u.id_ligue = l.id_ligue
                           WHERE u.id_ligue = :id_ligue
                           ORDER BY f.dat_question DESC");
    $stmt->execute(['id_ligue' => $user_ligue]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Foire aux Questions</title>
    <link rel="stylesheet" href="css/faq.css">
</head>
<body>
<nav class="navbar">
    <?php if ($isAdmin || $isSuperAdmin): ?>
        <a href="age.php" style="color: wheat;">
            Liste age users
        </a>
    <?php endif; ?>
    <a href="index.php" style="color: wheat;">Revenir à l'accueil</a>
    <a href="logout.php" style="color: red;">Se déconnecter</a>
</nav>

<h3 style="text-align: center;">
    Bienvenue sur la foire aux questions, <?= $_SESSION['pseudo'] ?>
</h3>

<form method="POST">
    <input type="text" name="question" placeholder="Posez une question..." required>
    <button type="submit" name="add_question">Ajouter une question</button>
</form>


<table>
    <tr>
        <th>Utilisateur</th>
        <th>Question</th>
        <th style="color: grey; font-size: 10px;">Date question</th>
        <th style="color: black;">Ligue</th>
        <th>Réponse</th>
        <th style="color: grey; font-size: 10px;">Date réponse</th>
        <?php if ($isAdmin || $isSuperAdmin): ?>
            <th>Supprimer</th>
            <th>Modifier</th>
        <?php endif; ?>
    </tr>

    <?php foreach ($questions as $row): ?>
        <tr>
            <td><?= $row['pseudo'] ?></td>
            <td><?= $row['question'] ?></td>
            <td style="color: grey; font-size: 10px;"><?= date('d/m/Y H:i', strtotime($row['dat_question'])) ?></td>
            <td><?= $row['lib_ligue']?></td>
            <td>
                <?php if (!empty($row['reponse'])): ?>
                    <?= $row['reponse'] ?>
                <?php elseif (($isAdmin && $row['id_ligue'] == $user_ligue) || $isSuperAdmin): ?>
                    <form method="POST">
                        <input type="hidden" name="question_id" value="<?= $row['id_faq'] ?>">
                        <input type="text" name="reponse" placeholder="Répondre" required>
                        <button type="submit" name="reply_question">Répondre</button>
                    </form>
                <?php endif; ?>
            </td>
            <td style="color: grey; font-size: 10px;">
                <?php if (!empty($row['dat_reponse'])): ?>
                    <?= date('d/m/Y H:i', strtotime($row['dat_reponse'])) ?>
                <?php else: ?>
                    <p style="color: gray;">En attente de la réponse</p>
                <?php endif; ?>
            </td>

            <?php if ($isAdmin || $isSuperAdmin): ?>
                <td>
                    <form method="POST">
                        <input type="hidden" name="question_id" value="<?= $row['id_faq'] ?>">
                        <button type="submit" name="delete_question">Supprimer</button>
                    </form>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="question_id" value="<?= $row['id_faq'] ?>">
                        <input type="text" name="new_question" placeholder="Modifier" value="<?= $row['question'] ?>" required>
                        <button type="submit" name="edit_question">Modifier</button>
                    </form>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
