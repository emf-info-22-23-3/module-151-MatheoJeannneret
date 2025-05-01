<?php

include_once('configConnection.php');

/**
 * Classe Connection
 *
 * Cette classe de gérer l'accès à la base de données.
 *
 */

class Connection
{

    private static $_instance = null;
    private $pdo;
    private $dbError;

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return Singleton de la connection
     */
    public static function getInstance()
    {
        if (is_null(value: self::$_instance)) {
            self::$_instance = new connection();
        }
        return self::$_instance;
    }

    /**
     * Fonction permettant d'ouvrir une connection à la base de données.
     */
    private function __construct()
    {
        try {
            $this->pdo = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_PERSISTENT => true
            ));
            $this->dbError = new ErrorAnswer("Error while trying to access the database. Please try again in a moment.", 500);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * Fonction permettant de fermer la connexion à la base de données.
     */
    public function __destruct()
    {
        $this->pdo = null;
    }

    /**
     * Fonction permettant d'exécuter un select dans MySQL.
     * A utiliser pour les SELECT.
     * 
     * @param String $query. Requête à exécuter.
     * @param Array $params. Contient les paramètres à ajouter à la requête (null si aucun paramètre n'est requis)
     * @return toutes les lignes du select
     */
    public function selectQuery($query, $params)
    {
        try {
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->execute($params);
            return $queryPrepared->fetchAll();
        } catch (PDOException $e) {
            return $this->dbError;
        }
    }

    /**
     * Fonction permettant d'exécuter un select avec une seule réponse dans MySQL.
     * A utiliser pour les SELECT.
     * 
     * @param String $query. Requête à exécuter.
     * @param Array $params. Contient les paramètres à ajouter à la requête (null si aucun paramètre n'est requis)
     * @return la première ligne du select
     */
    public function selectSingleQuery($query, $params)
    {
        try {
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->execute($params);
            return $queryPrepared->fetch();
        } catch (PDOException $e) {
            return $this->dbError;
        }
    }

    /**
     * Fonction permettant d'exécuter une requête MySQL.
     * A utiliser pour les UPDATE, DELETE, INSERT.
     *
     * @param String $query. Requête à exécuter.
     * @param Array $params. Contient les paramètres à ajouter à la requête  (null si aucun paramètre n'est requis)
     * @return le nombre de lignes affectées par la requête
     */
    public function executeQuery($query, $params)
    {
        try {
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->execute($params);
            return $queryPrepared->rowCount();
        } catch (PDOException $e) {
            return $this->dbError;
        }
    }

    /**
     * Fonction permettant d'obtenir le dernier id inséré.
     * 
     * @param String $table. la table où a été inséré l'objet. 
     * @return int: l'id du dernier élément inséré.
     */
    public function getLastId($table)
    {
        try {
            $lastId = $this->pdo->lastInsertId($table);
            return $lastId;
        } catch (PDOException $e) {
            return $this->dbError;
        }
    }
}
