<?php

// Inclure le fichier contenant la classe
require_once 'Wrk.php';

// Instancier la classe
$wrk = new Wrk();

// Récupérer les équipes
$equipes = $wrk->getEquipes();

// Retourner les équipes en format JSON
header('Content-Type: application/json');
echo json_encode(['equipes' => $equipes]);
