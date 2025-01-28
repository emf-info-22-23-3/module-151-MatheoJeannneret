<?php

class Wrk
{

    private $bdd;
    public function __construct()
    {
        try {
            $this->bdd = new PDO('mysql:host=database;dbname=hockey_stats', 'root', 'root');
        } catch (Exception $e) {
            die('Erreur :' . $e->getMessage());
        }
    }

    public function getEquipes(): array
    {
        $retour = array();
        $sqlQuery = 'SELECT * FROM t_equipe';
        $recipesStatement = $this->bdd->prepare($sqlQuery);
        $recipesStatement->execute();
        $recipes = $recipesStatement->fetchAll();
        foreach ($recipes as $recipe) {
            array_push($retour, new Equipe($recipe['PK_equipe'], $recipe['Nom']));
        }
        $recipesStatement->closeCursor();
        return $retour;
    }

    public function getPlayers($team): array {
        
    }
}
