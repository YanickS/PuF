<?php 

namespace Recherche;

class ModelRecherche {

    protected $pdo;

    // Constructeur Recherche
    public function __construct(){
        try {
            $this->pdo = new \PDO('mysql:host=localhost;dbname=pufhcm_it', 'root', 'root');
            $this->pdo->exec('SET CHARSET UTF8');
        } catch (\PDOException $exception) {
            die('Impossible de se connecter au serveur MySQL');
        }
    }

    protected function fetchOne(\PDOStatement $query)
    {
        if ($query->rowCount() != 1) {
            return false;
        } else {
            return $query->fetch();
        }
    }

     public function getContentsSearch($q){  

            $sql = "SELECT * FROM contenu c, page p WHERE c.idPage = p.id AND FR LIKE '%".$q."%' LIMIT 0, 10";
            $query = $this->pdo->prepare($sql);
            $query->execute();
           
            $donnees = $query->fetchAll(\PDO::FETCH_ASSOC);
            
            foreach ($donnees as $d) {
                $suggestions['suggestions'][] = $d['libelle'].' - '.$d['FR'];
            }

            if (!isset($suggestions)){
                $suggestions['suggestions'][] = "Pas de résultats";
            }
            
            return json_encode($suggestions);
    }

    public function getPathByName($libelle){
        $sql = "SELECT * FROM page WHERE libelle = ?";
        $query = $this->pdo->prepare($sql);
        $query->execute(array($libelle));
        return $this->fetchOne($query);
    }
}

?>