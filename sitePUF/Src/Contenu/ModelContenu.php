<?php 

namespace Contenu;

class ModelContenu {

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

    public function getContenuPage($idPage){  
        $sql = 'SELECT * FROM contenu as c where idPage = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array($idPage));
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}