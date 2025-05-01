<?php

class User implements JsonSerializable
{
    private $nom;
    private $isAdmin;
    private $pkUser;

    public function __construct($nom, $isAdmin, $pkUser)
    {
        $this->nom = $nom;
        $this->isAdmin = $isAdmin;
        $this->pkUser = $pkUser;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'nom' => $this->nom,
            'isAdmin' => $this->isAdmin,
            'id' => $this->pkUser
        ];
    }

    public function getPkUser()
    {
        return $this->pkUser;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }
}
