<?
namespace Model;
use PDO;
 class MembreModel extends Model{
   public function selectAllMembre($order=null){
     return $this->selectAll($order=null);
     }

   public function selectMembre($id){
       return $this->select($id);
     }

   public function deleteMembre($id){
     return $this->delete($id);
   }

   public function inscription($infos){
     return $this->insert($infos);
   }

   public function updateMembre($id,$infos){
     return $this->update($id,$infos);
   }

   public function deleteAllMembre(){
   return $this->deleteAll();
   }

public function existsPseudo($pseudo){
$request = "SELECT * FROM ".$this->table." WHERE pseudo =:pseudo";
$resultat=$this->getDb()->prepare($request);
$resultat->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
$resultat->execute();
$resultat->setFetchMode(PDO::FETCH_CLASS,'Entity\\'.$this->table );
$data=$resultat->fetch();
if($data) return $data;
else return false;
}


}
?>
