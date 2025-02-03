<?php

class Ctrl
{
    private $wrk;

    public function __construct()
    {
        $this->wrk = new Wrk();
    }

    public function getEquipes()
    {
        $equipes = $this->wrk->getEquipes();
        $retour = "<equipes>";
        foreach ($equipes as $key => $value) {
            $retour .= "<equipe><id>" . $value->getEquipe() . "</id><nom>" . $value->getNom() . "</nom></equipe>";
        }
        $retour .= "</equipes>";
        return $retour;
    }

    public function getPlayers($team)
    {
        $players = $this->wrk->getPlayers($team);
        $retour = "<players>";
        foreach ($players as $key => $value) {
            $retour .= "<player><id>" . $value->getId() . "</id><nom>" . $value->getNom() . "</nom><points>" . $value->getPoints() . "</points></player>";
        }
        $retour .= "</players>";
        return $retour;
    }
}
