<?php
try {
	$bdd = new PDO('mysql:host=localhost;dbname=nomDB', 'root', 'pwd');
} catch (Exception $e) {
	die('Erreur :' . $e->getMessage());
}

$reponse = $bdd->prepare("SELECT titre FROM jeux_video");
$reponse->execute();
while ($donne = $reponse->fetch()) {
	echo $donne['titre'] . '<br>';
}
$reponse->closeCursor();
