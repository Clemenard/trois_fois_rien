<?
namespace Model;
abstract class ProduitModel extends Model{

  public function selectAllProduit($order=null){
    return $this->selectAll($order=null);
    }

  public function selectProduit($id){
      return $this->select($id);
    }

  public function deleteProduit($id){
    return $this->delete($id);
  }

  public function insertProduit($infos){
    return $this->insert($infos);
  }

  public function updateProduit($id,$infos){
    return $this->update($id,$infos);
  }

  public function deleteAllProduit(){
  return $this->deleteAll();
  }


  public function getAllCategories(){
    $q=$this->getDb()->execRequest('SELECT DISTINCT categorie FROM '.$this->table.' ORDER BY categorie');
    $donnes=$q->fetchAll();
    if(!empty($data)){
      return false;
    }
    else{
    return $data;}
  }

  public function getAllProduitsByCategories($cat){
    $q=$this->getDb()->execRequest('SELECT * FROM '.$this->table.' WHERE categorie=:cat',array('cat'=:$cat));
    $donnes=$q->fetchAll();
    if(!empty($data)){
      return false;
    }
    else{
    return $data;}
  }

      public function getResultSearch($term){
        $q=$this->getDb()->execRequest('SELECT * FROM '.$this->table. "WHERE LOWER (titre) LIKE CONCAT('%',:term,'%')".
        "OR LOWER (categorie) LIKE CONCAT('%',:term,'%') ".
        "OR LOWER (description) LIKE CONCAT('%',:term,'%')" .
        "OR LOWER (couleur) LIKE CONCAT('%',:term,'%')" ,
        array('term'=:$term));
        $data=$q->fetch(PDO::FETCH_CLASS,'Entity\\'.ucfirst($this->table));
        if(!empty($data)){
          return false;
        }
        else{
        return $data;}
}
?>
