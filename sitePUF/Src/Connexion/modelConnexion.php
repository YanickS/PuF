<?php

namespace Connexion;
use Utilisateur\ModelUtilisateur;

/**
 * Représente le "Model", c'est à dire l'accès à la base de
 * données
 */
class ModelConnexion
{
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO('mysql:host=localhost;dbname=pufhcm_it', 'root', 'root');
            $this->pdo->exec('SET CHARSET UTF8');
        } catch (\PDOException $exception) {
            echo($exception);
            die('Impossible de se connecter au serveur MySQL');
        }
    }

    /**
     * Récupère un résultat exactement
     */
    protected function fetchOne(\PDOStatement $query)
    {
        if ($query->rowCount() != 1) {
            return false;
        } else {
            return $query->fetch();
        }
    }

    public function GetUtilisateurByLogin($email, $motDePasse){
        // Comparaison du login et du mot de passe avec ceux de la BDD
        $sql = 'SELECT * FROM utilisateur WHERE email = ? AND mdp = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($email), md5(htmlentities($motDePasse))));
        //var_dump(md5(htmlentities($motDePasse)));
        $res = $this->fetchOne($query);

        if($res != false){
            $id = $res["id"];
            $email = $res["email"];
            $mdp = $res["mdp"];
            $admin = $res["admin"];
            // Création d'une personne
            $utilisateur = new ModelUtilisateur($id,  $email, $mdp, $admin) or die("Erreur constructeur Utilisateur");
            return $utilisateur;
        }

        return false;        
    }
}
