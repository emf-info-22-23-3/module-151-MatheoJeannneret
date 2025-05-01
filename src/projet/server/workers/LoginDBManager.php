<?php

class LoginDBManager
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function checkLogin($nom, $password)
    {
        $query = "SELECT pk_utilisateur, nom, password, is_admin FROM t_utilisateur WHERE nom = :nom";
        $params = array('nom' => $nom);
        $user = $this->db->selectSingleQuery($query, $params);
        $retour = NULL;
        if ($user && !($user instanceof ErrorAnswer) and password_verify($password, $user['password'])) {
            $retour = new User($user["nom"], $user["is_admin"], $user["pk_utilisateur"]);
        } else {
            $retour = new ErrorAnswer("The provided login/password does not match.", 401);
        }
        return $retour;
    }
}
