<?
namespace Controller;
class ProduitController extends Controller{
  public function all(){
    $produits = $this->getModel()->selectAllProduit();
    $categories = $this->getModel()->getAllCategories();
    $params=array(
      'produits'=> $produits,
      'categories'=>$categories
    );

    return $this->render('layout.html','boutique.html',$params);
  }

  public function afficheCategorie($cat){
    $produits = $this->getModel()->getAllProduitsByCategories($cat);
    $categories = $this->getModel()->getAllCategories();

    $params=array(
      'produits'=> $produits,
      'categories'=>$categories
    );
    return $this->render('layout.html','boutique.html',$params);
  }

  public function affiche($id){
    $message = '';
    if(!empty($_POST)){
      $this->ajouterArticlePanier($_POST['id_produit'],$_POST['quantite']);
      $message = 'Le message a été ajoué au panier';
    }
    $produit = $this->getModel()->selectProduit($id);


    $params=array(
      'produit'=> $produit,
      'message'=>$message
    );
    return $this->render('layout.html','fiche_produit.html',$params);
  }

  public function recherche(){
    if(!empty($_POST['term'])){
      $produits = $this->getModel()->getResultSearch($_POST['term']);
      $nbresult = ($produits) ? count($produits) : 0;
      $title = "Recherche de ".$_POST['term'];

      $params=array(
        'produits'=> $produits,
        'nbresult'=>$nbresult,
        'title'=>$title
      );
          return $this->render('layout.html','recherche.html',$params);
    }

else{
  $this->all();

}
  }

    public function panier(){
      if(!empty($_POST['viderpanier'])){
        $this->viderPanier();
      }
      if(!empty($_SESSION['panier'])){
        $params['content_panier']=array();
        for($i=0;$i<count($_SESSION['panier']['id_produit']);$i++){
        $params['content_panier'][$i]= $this->getModel()->selectProduit($_SESSION['panier']['id_produit'][$i]);
        }
        $params['title']='Panier';
        return $this->render('layout.html','panier.html',$params);
    }}

  public function creationPanier(){
    if(!isset($_SESSION['panier'])){
      $_SESSION['panier']['id_produit']=array();
      $_SESSION['panier']['prix']=array();
      $_SESSION['panier']['quantite']=array();
    }
  }
  public function viderPanier(){
    if(isset($_SESSION['panier'])){
      unset($_SESSION['panier']);
    }
  }
  public function ajouterArticlePanier($id_produit,$quantite){
    $this->creationPanier();
    $position_produit=array_search($id_produit,$_SESSION['panier']['id_produit']);
    if($position_produit !==false){
      $_SESSION['panier']['quantite'][$position_produit]+=$quantite;
    }
    else{
      $_SESSION['panier']['id_produit'][]=$id_produit;
      $_SESSION['panier']['prix'][]=$this->getModel()->selectProduit($id_produit)->getField('prix');
      $_SESSION['panier']['quantite'][]=$quantite;
    }
  }
}
?>
