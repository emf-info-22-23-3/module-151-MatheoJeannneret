<?php

declare(strict_types=1);

class Wrk
{
    // Définir la propriété privée pour stocker les équipes
    private $equipes;

    // Constructeur pour initialiser les équipes
    public function __construct()
    {
        $this->equipes = ['Gotteron', 'SC Bern', 'Fribourg-Gottéron', 'HC Davos'];
    }

    // Méthode pour obtenir toutes les équipes
    public function getEquipes()
    {
        return $this->equipes;
    }
}
