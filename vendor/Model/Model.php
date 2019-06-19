<?
namespace Model;
use PDO, \Manager\PDOManager;
abstract class Model{
protected $db;
protected $table;

public function __construct(){
  $this->db = PDOManager::getInstance()->getPDO();
  $this->table=strtolower(str_replace(array('Model\\','Model'),'',get_called_class()));

}

public function getDb(){
  return $this->db;
}
public function getTable(){
  return $this->table;
}
public function execRequest($req,$params=array()){
  $r = $this->getDb()->prepare($req);
  if ( !empty($params) ){
    // sanatize et bindvalue
    foreach($params as $key => $value){
      $params[$key] = htmlspecialchars($value,ENT_QUOTES);
      $r->bindValue($key,$params[$key],PDO::PARAM_STR);
    }
  }
  $r->execute();
  if ( !empty( $r->errorInfo()[2] )){
    die('Erreur rencontrée - merci de contacter l\'administrateur');
  }
  return $r;
}


public function getKeys(){
  $q=$thisexecRequest('DESC '.$this->table);
  $r=$q->fetchAll();
  return array_slice($r,1);// on retourne tout sauf l'ID
}

public function selectAll($order=null){
  if(!is_null($order)) $order='ORDER BY'.$order;
    $q=$this->execRequest('SELECT * FROM '.$this->table.' '.$order);
    $data=$q->fetchAll(PDO::FETCH_CLASS,'Entity\\'.ucfirst($this->table));
    if(!$data){
      return false;
    }
    else{
    return $data;}
  }

public function select($id){

    $q=$this->execRequest('SELECT * FROM '.$this->table.' WHERE id_'.$this->table.' = :id',array('id'=>$id));
      $q->setFetchMode(PDO::FETCH_CLASS,'Entity\\'.ucfirst($this->table));
    $data=$q->fetch();
    if(!$data){
      return false;
    }
    else{
    return $data;}
  }

public function delete($id){
  $q=$this->execRequest('DELETE FROM '.$this->table.' WHERE id_'.$this->table.' = :id',array('id'=>$id));
}

public function insert($infos){
  $q=$this->execRequest('INSERT INTO '.$this->table.' ('.implode(',', array_keys($infos)).') VALUES (:'.implode(',:', array_keys($infos)).')',$_POST);
  return $this->getDb()->lastInsertId();
}

public function update($id,$infos){
  foreach($infos as $values){
    $newValues[]="$key = :$key";
  }
$infos['id']=$id;
  $q=$this->execRequest('UPDATE '.$this->table.' SET '.implode(',',$newValues) .' WHERE id_'.$this->table.' = :id',$infos);
}

public function deleteAll(){
  $q=$this->execRequest('DELETE FROM '.$this->table);
}

public function truncate(){
  $q=$this->execRequest('TRUNCATE TABLE '.$this->table);
}
}


?>
