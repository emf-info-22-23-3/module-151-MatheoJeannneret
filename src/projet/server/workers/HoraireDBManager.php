<?php

class HoraireDBManager
{

    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getAllHoraires()
    {
        $query = "SELECT h.pk_horaire, h.dateDepart, l1.nom AS localite_depart, l2.nom AS localite_destination, tt.abreviation AS type_train FROM t_horaire h JOIN t_localite l1 ON h.fk_localite_depart = l1.pk_localite JOIN t_localite l2 ON h.fk_localite_destination = l2.pk_localite JOIN t_typeTrain tt ON h.fk_typeTrain = tt.pk_typeTrain;";
        $horaires = $this->db->selectQuery($query, NULL);
        $retour = [];
        if ($horaires && !($horaires instanceof ErrorAnswer)) {
            foreach ($horaires as $h) {
                $horaire = new Horaire($h['pk_horaire'], $h['dateDepart'], $h['localite_depart'], $h['localite_destination'], $h['type_train']);
                $retour[] = $horaire;
            }
        } else {
            $retour = new ErrorAnswer("No horaire found.", 404);
        }
        return $retour;
    }

    public function createHoraire($dateDepart, $fk_localite_depart, $fk_localite_destination, $fk_typeTrain)
    {
        $query = "INSERT INTO t_horaire (dateDepart, fk_localite_depart, fk_localite_destination, fk_typeTrain) 
              VALUES (:dateDepart, :fk_localite_depart, :fk_localite_destination, :fk_typeTrain)";

        $params = array(
            ':dateDepart' => $dateDepart,
            ':fk_localite_depart' => $fk_localite_depart,
            ':fk_localite_destination' => $fk_localite_destination,
            ':fk_typeTrain' => $fk_typeTrain
        );

        $result = $this->db->executeQuery($query, $params);

        if ($result > 0) {
            return ["message" => "Horaire cree", "code" => 200];
        } else {
            return new ErrorAnswer("Erreur lors de l'insertion de l'horaire.", 500);
        }
    }

    public function deleteHoraire($pk_horaire)
    {
        $this->db->startTransaction();

        $query = "DELETE FROM t_horaire WHERE pk_horaire = :pk_horaire";
        $params = array(':pk_horaire' => $pk_horaire);

        $success = $this->db->addQueryToTransaction($query, $params);

        if ($success) {
            $this->db->commitTransaction();
            return ["message" => "Horaire supp", "code" => 200];
        } else {
            $this->db->rollbackTransaction();
            return new ErrorAnswer("Erreur lors de la suppression de l'horaire.", 500);
        }
    }

    public function updateHoraire($pk_horaire, $dateDepart, $fk_localite_depart, $fk_localite_destination, $fk_typeTrain)
    {
        $this->db->startTransaction();

        $query = "UPDATE t_horaire 
              SET dateDepart = :dateDepart, 
                  fk_localite_depart = :fk_localite_depart, 
                  fk_localite_destination = :fk_localite_destination, 
                  fk_typeTrain = :fk_typeTrain 
              WHERE pk_horaire = :pk_horaire";

        $params = array(
            ':dateDepart' => $dateDepart,
            ':fk_localite_depart' => $fk_localite_depart,
            ':fk_localite_destination' => $fk_localite_destination,
            ':fk_typeTrain' => $fk_typeTrain,
            ':pk_horaire' => $pk_horaire
        );

        $success = $this->db->addQueryToTransaction($query, $params);

        if ($success) {
            $this->db->commitTransaction();
            return ["message" => "Horaire maj", "code" => 200];
        } else {
            $this->db->rollbackTransaction();
            return new ErrorAnswer("Erreur lors de la maj de l'horaire.", 500);
        }
    }
}
