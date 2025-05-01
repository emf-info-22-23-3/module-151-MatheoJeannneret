<?php

/**
 * Classe ErrorAnswer
 *
 * Cette classe représente une réponse d'erreur avec un message et un statut.
 * @version 1.0
 * @author Mathéo Jeanneret
 */
class ErrorAnswer
{
    public $message;
    private $status;
    /**
     * Constructeur de la classe ErrorAnswer.
     * 
     * @param string $message Le message d'erreur.
     * @param int $status Le statut de l'erreur.
     */
    public function __construct($message, $status)
    {
        $this->message = $message;
        $this->status = $status;
    }
    /**
     * Méthode permettant de récupérer le statut de l'erreur.
     *
     * @return int Le statut de l'erreur.
     */
    public function getStatus()
    {
        return $this->status;
    }
}
