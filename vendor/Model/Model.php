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
  $q=$this->getDb()->execRequest('DESC '.$this->table);
  $r=$q->fetchAll();
  return array_slice($r,1);// on retourne tout sauf l'ID
}

public function selectAll($order=null){
  if(!is_null($order)) $order='ORDER BY'.$order;
    $q=$this->getDb()->execRequest('SELECT * FROM '.$this->table.' '.$order);
    $data=$q->fetchAll();
    if(!$data){
      return false;
    }
    else{
    return $data;}
  }

public function select($id){
    $q=$this->getDb()->execRequest('SELECT * FROM '.$this->table.' WHERE id_'.$this->table.' = :id',array('id'=>$id));
    $data=$q->fetch(PDO::FETCH_CLASS,'Entity\\'.ucfirst($this->table));
    if(!$data){
      return false;
    }
    else{
    return $data;}
  }

public function delete($id){
  $q=$this->getDb()->execRequest('DELETE FROM '.$this->table.' WHERE id_'.$this->table.' = :id',array('id'=>$id));
}

public function insert(){
  $q=$this->getDb()->execRequest('INSERT INTO '.$this->table.' ('.implode(',', array_keys($_POST)).') VALUES (:'.implode(',:', array_keys($_POST)).')',$_POST);
  return $this->getDb()->lastInsertId();
}

public function update(){
  $c=array();
  foreach($_POST as $key=>$value){
    $c[]=$key.'=:'.$key;
    }
$_POST['id']=$_GET['id'];
  $q=$this->getDb()->execRequest('UPDATE '.$this->table.' SET '.implode(',',$c) .' WHERE id_'.$this->table.' = :id',$_POST);
}

public function deleteAll(){
  $q=$this->getDb()->execRequest('DELETE FROM '.$this->table);
}

public function truncate(){
  $q=$this->getDb()->execRequest('TRUNCATE TABLE '.$this->table);
}
}


?>
