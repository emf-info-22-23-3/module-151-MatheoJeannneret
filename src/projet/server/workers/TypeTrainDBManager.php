<?php

class TypeTrainDBManager
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getAllTypes()
    {
        $query = "SELECT pk_typeTrain, nomComplet, abreviation FROM t_typeTrain";
        $allTypes = $this->db->selectQuery($query, NULL);
        $retour = [];
        if ($allTypes && !($allTypes instanceof ErrorAnswer)) {
            foreach ($allTypes as $type) {
                $typeTrain = new TypeTrain($type['nomComplet'], $type['abreviation'], $type['pk_typeTrain']);
                $retour[] = $typeTrain;
            }
        } else {
            $retour = new ErrorAnswer("No train types found.", 404);
        }
        return $retour;
    }

    public function getTypeById($pkTypeTrain)
    {
        $query = "SELECT pk_typeTrain, nomComplet, abreviation FROM t_typeTrain WHERE pk_typeTrain = :id";
        $params = ['id' => $pkTypeTrain];
        $result = $this->db->selectSingleQuery($query, $params);

        if ($result && !($result instanceof ErrorAnswer)) {
            return new TypeTrain($result['nomComplet'], $result['abreviation'], $result['pk_typeTrain']);
        } else {
            return new ErrorAnswer("Train type not found.", 404);
        }
    }
}
