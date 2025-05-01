<?php

class LocaliteManager
{

    private $wrkLocalite;

    public function __construct()
    {
        $this->wrkLocalite = new LocaliteDBManager();
    }

    public function getAllLocalites()
    {
        return $this->wrkLocalite->getAllLocalites();
    }

    public function getTypeById($pkLocalite)
    {
        $retour = NULL;
        if ($this->checkParam($pkLocalite)) {
            $retour = $this->wrkLocalite->getLocaliteById($pkLocalite);
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

    private function checkParam($param)
    {
        $isValid = false;

        if (!empty(trim($param)) and is_string($param)) {
            $isValid = true;
        }
        return $isValid;
    }
}
