<?php
class objet{
    public function get($attribut){
        return $this->$attribut;
    }

    public function set($attribut, $valeur){
        $this->$attribut = $valeur;
    }


    public static function getAll(){
        $classeRecuperee = static::$classe;
        $requete = "SELECT * FROM $classeRecuperee;";
        $resultat = connexion::pdo()->query($requete);
        $resultat->setFetchmode(PDO::FETCH_CLASS, $classeRecuperee);
        $tableau = $resultat->fetchAll();
        return $tableau;
    }

    public static function delete($id){
        $classeRecuperee = static::$classe;
        $identifiant = static::$identifiant;
        $requetePreparee = "DELETE FROM $classeRecuperee WHERE $identifiant = :id_tag;"; 
        $resultat = connexion::pdo()->prepare($requetePreparee);

        $tags = array("id_tag" => $id);
        try{
            $resultat->execute($tags);
            $resultat->setFetchmode(PDO::FETCH_CLASS, $classeRecuperee);
            $element = $resultat->fetch();
            return $element;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
        $tags = array("id_tag" => $id);
}

    public static function create($donnees)
    {
        $classeRecuperee = static::$classe;
        $requetePreparee = "INSERT INTO $classeRecuperee (";
        $columns = array_keys($donnees);
        $values = array_values($donnees);

        $requetePreparee .= implode(", ", $columns);
        $requetePreparee .= ") VALUES (";
        $requetePreparee .= implode(", ", array_fill(0, count($values), "?"));
        $requetePreparee .= ");";

        $resultat = connexion::pdo()->prepare($requetePreparee);
        try {
            $resultat->execute($values);
            $resultat->setFetchmode(PDO::FETCH_CLASS, $classeRecuperee);
            $element = $resultat->fetch();
            return $element;
        } catch(PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }


    public static function getOne($id){
        $classeRecuperee = static::$classe;
        $identifiant = static::$identifiant;
        $requetePreparee = "SELECT * FROM $classeRecuperee WHERE $identifiant = :id_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);

        $tags = array("id_tag" => $id);
        try{
            $resultat->execute($tags);
            $resultat->setFetchmode(PDO::FETCH_CLASS, $classeRecuperee);
            $element = $resultat->fetch();
            return $element;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }

    public static function nextId() {
        $classeRecuperee = static::$classe;
        $identifiant = static::$identifiant;
        $requete = "SELECT MAX($identifiant) AS max_id FROM $classeRecuperee";
        $resultat = connexion::pdo()->query($requete);
        $maxId = $resultat->fetchColumn();

        // Si aucun enregistrement n'existe encore dans la table, initialise l'identifiant à 1
        if ($maxId === false || $maxId === null) {
            return 1;
        }

        // Sinon, retourne le prochain identifiant disponible en l'incrémentant de 1
        return $maxId + 1;
    }
    
}


?>