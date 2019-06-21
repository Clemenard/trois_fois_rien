<?php

namespace Model;
use PDO;

class MembreModel extends Model{

  public function inscription($infos){
    return $this->register($infos);
  }
  public function updateMembre($infos){
    return $this->update($infos);
  }

  public function existsPseudo($pseudo){
    $requete = "SELECT * FROM " . $this->table." WHERE pseudo = :pseudo";
    $resultat = $this->getDb()->prepare($requete);
    $resultat->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
    $resultat->execute();
    $resultat->setFetchMode(PDO::FETCH_CLASS,'Entity\\' . $this->table);
    $donnees = $resultat->fetch();
    if( $donnees ) return $donnees;
    else return false;
  }

}
