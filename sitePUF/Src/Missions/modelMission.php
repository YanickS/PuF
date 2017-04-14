<?php

namespace Missions;

class ModelMission {

    protected $pdo;

    // Constructeur connexion
    public function __construct(){
        try {
            $this->pdo = new \PDO('mysql:host=localhost;dbname=pufhcm_it', 'root', 'root');
            $this->pdo->exec('SET CHARSET UTF8');
        } catch (\PDOException $exception) {
            die('Impossible de se connecter au serveur MySQL');
        }
    }

    // Retourne un résultat unique
    protected function fetchOne(\PDOStatement $query){
        if($query->rowCount() != 1)
            return false;
        else
            return $query->fetch();
    }

    // Récupère la liste des missions et les transforme en JSON
    public function getMissionsJSON(){
        $sql = 'SELECT * FROM mission ORDER BY id';
        $res = $this->pdo->query($sql);
        return json_encode($res->fetchAll(\PDO::FETCH_ASSOC));
    }

    // Récupère les details d'une mission selon un ID
    public function getDetailsMissionById($id){
        $sql = 'SELECT m.id, m.title, m.start, m.end, m.fiche, m.backgroundColor, m.textColor, m.idModule, 
                mo.libelle as libelleModule, s.id as idSemestre, s.libelle as libelleSemestre, f.id as idFormation, 
                f.libelle as libelleFormation 
                FROM mission as m, module as mo, semestre as s, compose as c, formation as f  
                WHERE m.id=? AND m.idFormation = f.id AND m.idModule = mo.id AND mo.idSemestre = s.id 
                AND s.id = c.idSemestre AND f.id = c.idFormation';
        $query = $this->pdo->prepare($sql);
        $query->execute(array($id));
        $res = $this->fetchOne($query);
        if($res != false){
            $tab["idMission"] = $res["id"];
            $tab["title"] = $res["title"];
            $tab["start"] = $res["start"];
            $tab["end"] = $res["end"];
            $tab["fiche"] = $res["fiche"];
            $tab["bgColor"] = $res["backgroundColor"];
            $tab["txtColor"] = $res["textColor"];
            $tab["idModule"] = $res["idModule"];
            $tab["libelleModule"] = $res["libelleModule"];
            $tab["idSemestre"] = $res["idSemestre"];
            $tab["libelleSemestre"] = $res["libelleSemestre"];
            $tab["idFormation"] = $res["idFormation"];
            $tab["libelleFormation"] = $res["libelleFormation"];
        }else{
            $tab["idMission"] = "";
            $tab["title"] = "";
            $tab["start"] = "";
            $tab["end"] = "";
            $tab["fiche"] = "";
            $tab["bgColor"] = "";
            $tab["txtColor"] = "";
            $tab["idModule"] = "";
            $tab["libelleModule"] = "";
            $tab["idSemestre"] = "";
            $tab["libelleSemestre"] = "";
            $tab["idFormation"] = "";
            $tab["libelleFormation"] = "";
        }
        
        $sql = 'SELECT e.id, e.coef, e.type, e.date FROM evaluation as e WHERE e.idMission=?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array($id));
        $res = $this->fetchOne($query);
        if($res != false){
            $tab["idEvaluation"] = $res["id"];
            $tab["coefEvaluation"] = $res["coef"];
            $tab["typeEvaluation"] = $res["type"];
            $tab["dateEvaluation"] = $res["date"];
        }else{
            $tab["idEvaluation"] = "";
            $tab["coefEvaluation"] = "";
            $tab["typeEvaluation"] = "";
            $tab["dateEvaluation"] = "";
        }


        $sql = 'SELECT i.id, s.libelle, s.id as idStatut, i.email, i.nom 
                FROM intervenant as i, encadrement as e , statut as s, caracterise as c 
                WHERE e.idMission = ? AND e.idIntervenant = i.id AND i.id = c.idIntervenant AND s.id = c.idStatut';
        $query = $this->pdo->prepare($sql);
        $requeteIntervenant = $query->execute(array($id));
        $resultats = $query->fetchAll(\PDO::FETCH_ASSOC);
        $i = 0;
        /* Init au cas ou pas de résultats */
        $tab["intervenants"][$i]["idIntervenant"] = "";
        $tab["intervenants"][$i]["email"] = "";
        $tab["intervenants"][$i]["nom"] = "";
        $tab["intervenants"][$i]["idStatutIntervenant"] = "";
        $tab["intervenants"][$i]["typeStatutIntervenant"] = "";
        if(count($resultats)<=2){
            foreach ($resultats as $intervenant){
                $tab["intervenants"][$i]["idIntervenant"] = $intervenant["id"];
                $tab["intervenants"][$i]["email"] = $intervenant["email"];
                $tab["intervenants"][$i]["nom"] = $intervenant["nom"];
                $tab["intervenants"][$i]["idStatutIntervenant"] = $intervenant["idStatut"];
                $tab["intervenants"][$i]["typeStatutIntervenant"] = $intervenant["libelle"];
                $i++;
            }
        }
        return json_encode($tab);
    }

    // Retourne les intervenants selon le statut : 2 = chargeTD, 1 = enseignant
    public function getIntervenants($idStatut){
        $sql =  'SELECT i.id, i.nom, i.email FROM intervenant as i, statut as s, caracterise as c '.
                'WHERE s.id = ? AND s.id = c.idStatut AND i.id = c.idIntervenant GROUP BY i.nom';
        $query = $this->pdo->prepare($sql);
        $query->execute(array($idStatut));
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retourne les modules selon le semestre :  1 = Semestre 1, 2 = Semestre 2
    public function getModulesBySemestre($idSemestre){
        $sql = 'SELECT m.id, m.libelle FROM module as m WHERE m.idSemestre = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array($idSemestre));
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retourne les formations
    public function getFormations(){
        $sql = 'SELECT f.id, f.libelle FROM formation as f';
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retourne les semestres
    public function getSemestres(){
        $sql = 'SELECT s.id, s.libelle FROM semestre as s';
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Ajout d'une mission : donnees evaluation optionnelles, donnees intervenants optionnelles
    public function addMission($titre, $debut, $fin, $fiche, $idModule, $idFormation, $bgColor, $txtColor, 
        $typeEval = null, $coefEval = null, $dateEval = null, $idChargeTD = null, $idEnseignant = null){
        
        // Ajout dans la table mission
        $sql =  'INSERT INTO mission (title, start, end, fiche, idModule, idFormation, backgroundColor, textColor) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($titre), htmlentities($debut), htmlentities($fin), htmlentities($fiche), 
                        htmlentities($idModule), htmlentities($idFormation), htmlentities($bgColor), htmlentities($txtColor)));
        $lastId = $this->pdo->lastInsertId();
        
        // Creation de la ligne d'évaluation même si non indiquée pour permettre l'update future
        $sql =  'INSERT INTO evaluation (type, coef, date, idMission) VALUES (?, ?, ?, ?)';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($typeEval), htmlentities($coefEval), htmlentities($dateEval), htmlentities($lastId)));

        // Si un chargeTD est indique 
        if($idChargeTD != null){
            $sql =  'INSERT INTO encadrement (idMission, idIntervenant) VALUES (?, ?)';
            $query = $this->pdo->prepare($sql);
            $query->execute(array($lastId, htmlentities($idChargeTD)));
        }
        // Si un enseignant est indique
        if($idEnseignant != null){
            $sql =  'INSERT INTO encadrement (idMission, idIntervenant) VALUES (?, ?)';
            $query = $this->pdo->prepare($sql);
            $query->execute(array($lastId, htmlentities($idEnseignant)));
        }
    }

    // Supprime une mission selon l'id
    public function delMissionById($idMission){
        // Suppression dans la table encadrement (Mission/Intervenant)
        $sql = 'DELETE FROM encadrement WHERE idMission = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($idMission)));

        // Suppression dans la table evaluation
        $sql = 'DELETE FROM evaluation WHERE idMission = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($idMission)));

        // Suppression dans la table mission
        $sql= 'DELETE FROM mission WHERE id = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($idMission)));
    }

    // Update des données liées à une mission (Evaluation et Intervenants optionnels)
    public function updateMission($idMission, $titre, $debut, $fin, $fiche, $idModule, $idFormation, $bgColor, $txtColor, 
        $typeEval = null, $coefEval = null, $dateEval = null, $idChargeTD = null, $idEnseignant = null){

        // Update de la table mission
        $sql = 'UPDATE mission SET title=?, start=?, end=?, fiche=?, idModule=?, idFormation=?, backgroundColor=?, textColor=? WHERE id=?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($titre), htmlentities($debut), htmlentities($fin), htmlentities($fiche), 
                    htmlentities($idModule), htmlentities($idFormation), htmlentities($bgColor), htmlentities($txtColor), 
                    htmlentities($idMission)));

        // Update de la table evaluation
        $sql =  'UPDATE evaluation SET type=?, coef=?, date=? WHERE idMission=?';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(htmlentities($typeEval), htmlentities($coefEval), htmlentities($dateEval), htmlentities($idMission)));

        /* Si un chargeTD ET un enseignant est indique */
        if($idChargeTD != null && $idEnseignant != null){
            $sql =  'DELETE FROM encadrement WHERE idMission = ?';
            $query = $this->pdo->prepare($sql);
            $query->execute(array(htmlentities($idMission)));
            $sql =  'INSERT INTO encadrement (idMission, idIntervenant) VALUES (?, ?)';
            $query = $this->pdo->prepare($sql);
            $query->execute(array(htmlentities($idMission), htmlentities($idEnseignant)));
            $sql =  'INSERT INTO encadrement (idMission, idIntervenant) VALUES (?, ?)';
            $query = $this->pdo->prepare($sql);
            $query->execute(array(htmlentities($idMission), htmlentities($idChargeTD)));
        // Si juste un enseignant est indiqué
        } elseif ($idEnseignant != null) {
            $sql =  'DELETE FROM encadrement WHERE idMission = ?';
            $query = $this->pdo->prepare($sql);
            $query->execute(array(htmlentities($idMission)));
            $sql =  'INSERT INTO encadrement (idMission, idIntervenant) VALUES (?, ?)';
            $query = $this->pdo->prepare($sql);
            $query->execute(array(htmlentities($idMission), htmlentities($idEnseignant)));
        // Si juste un chargeTD est indiqué
        } elseif ($idChargeTD != null){
            $sql =  'DELETE FROM encadrement WHERE idMission = ?';
            $query = $this->pdo->prepare($sql);
            $query->execute(array(htmlentities($idMission)));
            $sql =  'INSERT INTO encadrement (idMission, idIntervenant) VALUES (?, ?)';
            $query = $this->pdo->prepare($sql);
            $query->execute(array(htmlentities($idMission), htmlentities($idChargeTD)));
        }
    }
}