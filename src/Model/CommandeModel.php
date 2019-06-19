<?
namespace Model;
use PDO;
 class CommandeModel extends Model{
   public function selectAllCommande($order=null){
     return $this->selectAll($order=null);
     }

   public function selectCommande($id){
       return $this->select($id);
     }

   public function deleteCommande($id){
     return $this->delete($id);
   }

   public function insertCommande($infos){
     return $this->insert($infos);
   }

   public function updateCommande($id,$infos){
     return $this->update($id,$infos);
   }

   public function deleteAllCommande(){
   return $this->deleteAll();
   }
}
?>
