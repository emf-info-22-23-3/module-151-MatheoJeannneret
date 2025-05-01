<?php

class TypeTrain implements JsonSerializable
{
    private $nom;
    private $abr;
    private $pkTypetrain;

    public function __construct($nom, $abr, $pkTypetrain)
    {
        $this->nom = $nom;
        $this->abr = $abr;
        $this->pkTypetrain = $pkTypetrain;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'nom' => $this->nom,
            'abreviation' => $this->abr,
            'id' => $this->pkTypetrain
        ];
    }

    public function getPkTypeTrain()
    {
        return $this->pkTypetrain;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getAbreviation()
    {
        return $this->abr;
    }
}
