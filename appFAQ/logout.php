<?php
/*Bon c'est simple c'est le script de deconnexion, on demarre la session pour la détruire,
suite à cette action le header va permettre de renvoyer l'utilisateur verx l'index 
le meme bout de code est utilisé dans le cours*/ 
session_start();
session_unset();
session_destroy();
setcookie(session_name(),'',-1,'/');
header("Location: index.php");
exit();
?>