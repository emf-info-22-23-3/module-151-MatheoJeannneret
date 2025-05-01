<?php

class User
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
