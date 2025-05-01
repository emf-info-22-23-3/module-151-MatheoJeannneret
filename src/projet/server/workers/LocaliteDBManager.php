<?php

class LocaliteDBManager
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getAllLocalites()
    {
        $query = "SELECT pk_localite, nom FROM t_localite";
        $allLocalites = $this->db->selectQuery($query, NULL);
        $retour = [];
        if ($allLocalites && !($allLocalites instanceof ErrorAnswer)) {
            foreach ($allLocalites as $loc) {
                $localite = new Localite($loc['nom'], $loc['pk_localite']);
                $retour[] = $localite;
            }
        } else {
            $retour = new ErrorAnswer("No localite found.", 404);
        }
        return $retour;
    }

    public function getLocaliteById($pkLocalite)
    {
        $query = "SELECT pk_localite, nom FROM t_localite WHERE pk_localite = :pk";
        $params = [":pk" => $pkLocalite];

        $result = $this->db->selectSingleQuery($query, $params);

        if ($result && !($result instanceof ErrorAnswer)) {
            return new Localite($result['nom'], $result['pk_localite']);
        } else {
            return new ErrorAnswer("Localité introuvable pour l'identifiant $pkLocalite", 404);
        }
    }
}
