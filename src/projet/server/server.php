<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");


include_once('beans/ErrorAnswer.php');
include_once('beans/HttpReturns.php');
include_once('beans/User.php');
include_once('beans/TypeTrain.php');
include_once('beans/Localite.php');
include_once('beans/Horaire.php');
include_once('controllers/LoginManager.php');
include_once('controllers/TypeTrainManager.php');
include_once('controllers/LocaliteManager.php');
include_once('controllers/HoraireManager.php');
include_once('workers/Connection.php');
include_once('workers/LoginDBManager.php');
include_once('workers/TypeTrainDBManager.php');
include_once('workers/LocaliteDBManager.php');
include_once('workers/HoraireDBManager.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    session_start();

    $json = file_get_contents('php://input');
    $receivedParams = json_decode($json, TRUE);

    $loginManager = new LoginManager();
    $typeTrainManager = new TypeTrainManager();
    $localiteManager = new LocaliteManager();
    $horaireManager = new HoraireManager();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $loginManager->checkReceivedParams(array('action'), $receivedParams) and $receivedParams['action'] == 'login') {
        if ($loginManager->checkReceivedParams(array('nom', 'password'), $receivedParams)) {
            $user = $loginManager->checkLogin($receivedParams['nom'], $receivedParams['password']);
            if ($user instanceof ErrorAnswer) {
                session_destroy();
                $_SESSION = array();
                http_response_code($user->getStatus());
                echo json_encode($user);
            } else {
                $_SESSION['user'] = $user;

                http_response_code(HttpReturns::HttpSuccess());
                echo json_encode($user);
            }
        } else {
            http_response_code(HttpReturns::BAD_REQUEST()->getStatus());
            echo json_encode(HttpReturns::BAD_REQUEST());
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' and $loginManager->checkReceivedParams(array('action'), $receivedParams) and $receivedParams['action'] == "logout") {
        $_SESSION = array();
        session_destroy();
        http_response_code(HttpReturns::HttpSuccess());
        echo json_encode("user success logout");
    } else if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        if ($user->isAdmin() == 1) {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    if ($typeTrainManager->checkReceivedParams(array('action'), $_GET) and $_GET['action'] == "getAllTypes") {
                        $types = $typeTrainManager->getAllTypes();
                        if ($types instanceof ErrorAnswer) {
                            http_response_code($types->getStatus());
                            echo json_encode($types);
                        } else {
                            http_response_code(HttpReturns::HttpSuccess());
                            echo json_encode($types);
                        }
                    } else if ($localiteManager->checkReceivedParams(array('action'), $_GET) and $_GET['action'] == "getAllLocalites") {
                        $localites = $localiteManager->getAllLocalites();
                        if ($localites instanceof ErrorAnswer) {
                            http_response_code($localites->getStatus());
                            echo json_encode($localites);
                        } else {
                            http_response_code(HttpReturns::HttpSuccess());
                            echo json_encode($localites);
                        }
                    } else if ($horaireManager->checkReceivedParams(array('action'), $_GET) and $_GET['action'] == "getAllHoraires") {
                        $horaires = $horaireManager->getAllHoraires();
                        if ($horaires instanceof ErrorAnswer) {
                            http_response_code($horaires->getStatus());
                            echo json_encode($horaires);
                        } else {
                            http_response_code(HttpReturns::HttpSuccess());
                            echo json_encode($horaires);
                        }
                    } else {
                        http_response_code(HttpReturns::BAD_REQUEST()->getStatus());
                        echo json_encode(HttpReturns::BAD_REQUEST());
                    }
                    break;
                case 'POST':
                    if ($horaireManager->checkReceivedParams(array('action'), $receivedParams) and $receivedParams['action'] == "createHoraire") {
                        $createHoraire = $horaireManager->createHoraire($receivedParams['dateDepart'], $receivedParams['localiteDepart'], $receivedParams['localiteDestination'], $receivedParams['typeTrain']);
                        if ($createHoraire instanceof ErrorAnswer) {
                            http_response_code($createHoraire->getStatus());
                            echo json_encode($createHoraire);
                        } else {
                            http_response_code(HttpReturns::HttpSuccess());
                            echo json_encode($createHoraire);
                        }
                    } else {
                        http_response_code(HttpReturns::BAD_REQUEST()->getStatus());
                        echo json_encode(HttpReturns::BAD_REQUEST());
                    }
                    break;
                case 'DELETE':
                    if ($horaireManager->checkReceivedParams(array('action'), $receivedParams) and $receivedParams['action'] == "deleteHoraire") {
                        $deleteHoraire = $horaireManager->deleteHoraire($receivedParams['pkHoraire']);
                        if ($deleteHoraire instanceof ErrorAnswer) {
                            http_response_code($deleteHoraire->getStatus());
                            echo json_encode($deleteHoraire);
                        } else {
                            http_response_code(HttpReturns::HttpSuccess());
                            echo json_encode($deleteHoraire);
                        }
                    } else {
                        http_response_code(HttpReturns::BAD_REQUEST()->getStatus());
                        echo json_encode(HttpReturns::BAD_REQUEST());
                    }
                    break;
                case 'PUT':
                    if ($horaireManager->checkReceivedParams(array('action'), $receivedParams) and $receivedParams['action'] == "updateHoraire") {
                        $updateHoraire = $horaireManager->updateHoraire($receivedParams['pkHoraire'], $receivedParams['dateDepart'], $receivedParams['localiteDepart'], $receivedParams['localiteDestination'], $receivedParams['typeTrain']);
                        if ($updateHoraire instanceof ErrorAnswer) {
                            http_response_code($updateHoraire->getStatus());
                            echo json_encode($updateHoraire);
                        } else {
                            http_response_code(HttpReturns::HttpSuccess());
                            echo json_encode($updateHoraire);
                        }
                    } else {
                        http_response_code(HttpReturns::BAD_REQUEST()->getStatus());
                        echo json_encode(HttpReturns::BAD_REQUEST());
                    }
                    break;
            }
        } else {
            http_response_code(HttpReturns::FORBIDDEN()->getStatus());
            echo json_encode(HttpReturns::FORBIDDEN());
        }
    } else {
        http_response_code(HttpReturns::UNAUTHORIZED()->getStatus());
        echo json_encode(HttpReturns::UNAUTHORIZED());
    }
}
