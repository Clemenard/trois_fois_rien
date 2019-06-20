<?
namespace Entity;
class Membre extends Entity {
protected $id_membre,$pseudo,$mdp,$nom,$prenom,$email,$civilite,$ville,$code_postal,$adresse,$statut;
  public function isAdmin(){
    if( $this->getField('statut')==1){
      return true;
    }
    else{
      return false;
    }
  }
}
?>
