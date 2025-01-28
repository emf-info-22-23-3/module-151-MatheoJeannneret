<?php

class Equipe
{

    private $pk;
    private $nom;

    public function __construct($id, $nom)
    {
        $this->pk = $id;
        $this->nom = $nom;
    }

    public function getEquipe()
    {
        return $this->pk;
    }
    public function getNom()
    {
        return $this->nom;
    }
}
