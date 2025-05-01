<?php

class Horaire implements JsonSerializable
{
    private $pkHoraire;
    private $dateDepart;
    private $localiteDepart;
    private $localiteDestination;
    private $typeTrain;

    public function __construct($pkHoraire, $dateDepart, $localiteDepart, $localiteDestination, $typeTrain)
    {
        $this->pkHoraire = $pkHoraire;
        $this->dateDepart = $dateDepart;
        $this->localiteDepart = $localiteDepart;
        $this->localiteDestination = $localiteDestination;
        $this->typeTrain = $typeTrain;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->pkHoraire,
            'dateDepart' => $this->dateDepart,
            'localiteDepart' => $this->localiteDepart,
            'localiteDestination' => $this->localiteDestination,
            'typeTrain' => $this->typeTrain,
        ];
    }

    public function getPkHoraire()
    {
        return $this->pkHoraire;
    }

    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    public function getLocaliteDepart()
    {
        return $this->localiteDepart;
    }

    public function getLocaliteDestination()
    {
        return $this->localiteDestination;
    }

    public function getTypeTrain()
    {
        return $this->typeTrain;
    }
}
