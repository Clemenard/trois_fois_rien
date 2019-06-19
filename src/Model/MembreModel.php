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

   public function insertMembre($infos){
     return $this->insert($infos);
   }

   public function updateMembre($id,$infos){
     return $this->update($id,$infos);
   }

   public function deleteAllMembre(){
   return $this->deleteAll();
   }

public function connexion(){

}

}
?>
