<?php

class LoginManager
{

    private $wrkLogin;

    public function LoginManager()
    {
        $this->wrkLogin = new LoginDBManager();
    }

    public function checkLogin($nom, $password)
    {
        $retour = NULL;
        if ($this->checkParam($nom) and $this->checkParam($password)) {
            $retour = $this->wrkLogin->checkLogin($nom, $password);
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
