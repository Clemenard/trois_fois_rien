<?php

namespace Model;
use PDO;

class CommandeModel extends Model{

  public function registerCommande($infos){
    return $this->insert($infos);
  }

  public function getMyCommande($id){
    return $this->select($id);
  }

  // --------------- SPECIFIQUE ------------------
  public function registerDetails($infos){
    $requete = "INSERT INTO details_" . $this->table. " (" . implode(',',array_keys($infos)) . ") VALUES (:" . implode(', :',array_keys($infos)) . ")";
    $resultat = $this->getDb()->prepare($requete);
    if( $resultat->execute($infos) ){
      return $this->getDb()->lastInsertId();
    }
    else{
      return false;
    }
  }

  public function getMesCommandes(){
    if(isset($_SESSION['membre'])){
      $monId = $_SESSION['membre']->getField('id_membre');
      $requete = "SELECT * FROM " . $this->table ." WHERE id_membre = :id_membre";
      $resultat = $this->getDb()->prepare($requete);
      $resultat->bindValue(':id_membre',$monId,PDO::PARAM_INT);
      $resultat->execute();
      $donnees = $resultat->fetchAll(PDO::FETCH_CLASS,'Entity\\'.ucfirst($this->table));
      if($donnees) return $donnees;
      else return false;
    }else{
      return false;
    }
  }

  public function getallDetailsCommandes(){

      $requete = "SELECT * FROM commande c, membre m, produit p, details_commande d WHERE  d.id_produit=p.id_produit AND d.id_commande=c.id_commande AND c.id_membre = m.id_membre";
      $resultat = $this->getDb()->prepare($requete);
      $resultat->execute();
      $donnees = $resultat->fetchAll();
      if($donnees) return $donnees;
      else return false;
    }
    public function getDetailsMyCommandes($id){

        $requete = "SELECT * FROM commande c, produit p, details_commande d WHERE  d.id_produit=p.id_produit AND d.id_commande=c.id_commande AND c.id_commande=:id";
        $resultat = $this->getDb()->prepare($requete);
              $resultat->bindValue(':id',$id,PDO::PARAM_INT);
        $resultat->execute();
        $donnees = $resultat->fetchAll();
        if($donnees) return $donnees;
        else return false;
      }

}
