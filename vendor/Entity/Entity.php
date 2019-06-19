<?
namespace Entity;
abstract class Entity{


public function getField($propriete){
return $this->$propriete;
}

public function setField($propriete,$value){
$this->$propriete = $value;
}

public function getFields(){
  return get_object_vars($this);
}

}


?>
