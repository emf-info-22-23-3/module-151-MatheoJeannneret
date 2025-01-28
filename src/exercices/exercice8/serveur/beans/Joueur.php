<?php

class Joueur
{

    private $id;
    private $points;
    private $nom;
    public function __construct($id, $points, $nom)
    {
        $this->id = $id;
        $this->points = $points;
        $this->nom = $nom;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getPoints()
    {
        return $this->points;
    }
    public function getNom()
    {
        return $this->nom;
    }
}
