<?php

class Localite implements JsonSerializable
{
    private $nom;
    private $pkLocalite;

    public function __construct($nom, $pkLocalite)
    {
        $this->nom = $nom;
        $this->pkLocalite = $pkLocalite;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'nom' => $this->nom,
            'id' => $this->pkLocalite
        ];
    }

    public function getPkLocalite()
    {
        return $this->pkLocalite;
    }

    public function getNom()
    {
        return $this->nom;
    }
}
