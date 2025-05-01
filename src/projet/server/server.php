<?php
include_once('beans/ErrorAnswer.php');
include_once('beans/HttpReturns.php');
include_once('beans/User.php');
include_once('controllers/LoginManager.php');
include_once('workers/Connection.php');
include_once('workers/LoginDBManager.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    session_start();

    $json = file_get_contents('php://input');
    $receivedParams = json_decode($json, TRUE);

    $loginManager = new LoginManager();

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
    } else { //aucune action trouvé
        http_response_code(HttpReturns::NOT_FOUND()->getStatus());
        echo json_encode(HttpReturns::NOT_FOUND());
    }
}
