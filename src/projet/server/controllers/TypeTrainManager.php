<?php

class TypeTrainManager
{

    private $wrkTypeTrain;

    public function __construct()
    {
        $this->wrkTypeTrain = new TypeTrainDBManager();
    }

    public function getAllTypes()
    {
        return $this->wrkTypeTrain->getAllTypes();
    }

    public function getTypeById($pkTypeTrain)
    {
        $retour = NULL;
        if ($this->checkParam($pkTypeTrain)) {
            $retour = $this->wrkTypeTrain->getTypeById($pkTypeTrain);
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
