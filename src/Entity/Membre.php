<?
namespace Entity;
class Membre extends Entity {
private $id_membre,$pseudo,$mdp,$nom,$prenom,$email,$civilite,$ville,$code_postal,$adresse,$statut;
  function isAdmin(){
    if( $this->getField('statut')==1){
      return true;
    }
    else{
      return false;
    }
  }
}
?>
