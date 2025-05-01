<?php

class HoraireManager
{

    private $wrkHoraire;

    public function __construct()
    {
        $this->wrkHoraire = new HoraireDBManager();
    }

    public function getAllHoraires()
    {
        return $this->wrkHoraire->getAllHoraires();
    }

    public function createHoraire($dateDepart, $fk_localite_depart, $fk_localite_destination, $fk_typeTrain)
    {
        $retour = NULL;
        if ($this->isValidSqlDate($dateDepart) and $this->isValidKey($fk_localite_depart) and $this->isValidKey($fk_localite_destination) and $this->isValidKey($fk_typeTrain)) {
            $retour = $this->wrkHoraire->createHoraire($dateDepart, $fk_localite_depart, $fk_localite_destination, $fk_typeTrain);
        } else {
            $retour = HttpReturns::BAD_REQUEST();
        }
        return $retour;
    }

    public function deleteHoraire($pk_horaire)
    {
        $retour = NULL;
        if ($this->isValidKey($pk_horaire)) {
            $retour = $this->wrkHoraire->deleteHoraire($pk_horaire);
        } else {
            $retour = HttpReturns::BAD_REQUEST();
        }
        return $retour;
    }

    public function updateHoraire($pk_horaire, $dateDepart, $fk_localite_depart, $fk_localite_destination, $fk_typeTrain)
    {
        $retour = NULL;
        if ($this->isValidKey($pk_horaire) and $this->isValidSqlDate($dateDepart) and $this->isValidKey($fk_localite_depart) and $this->isValidKey($fk_localite_destination) and $this->isValidKey($fk_typeTrain)) {
            $retour = $this->wrkHoraire->updateHoraire($pk_horaire, $dateDepart, $fk_localite_depart, $fk_localite_destination, $fk_typeTrain);
        } else {
            $retour = HttpReturns::BAD_REQUEST();
        }
        return $retour;
    }

    public function checkReceivedParams($params, $data)
    {
        $isSet = true;
        foreach ($params as $param) {
            if (!isset($data[$param])) {
                $isSet = false;
                break;
            }
        }
        return $isSet;
    }

    private function isValidSqlDate($date)
    {
        if (is_null($date) || trim($date) === '') {
            return false;
        }

        // Vérifie le format YYYY-MM-DD
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }

        // Vérifie si c'est une date réelle
        [$year, $month, $day] = explode('-', $date);
        return checkdate((int)$month, (int)$day, (int)$year);
    }

    private function isValidKey($param)
    {
        $paramStr = (string) $param;
        return $param !== null && $paramStr !== '' && ctype_digit($paramStr) && $paramStr[0] !== '0';
    }
}
