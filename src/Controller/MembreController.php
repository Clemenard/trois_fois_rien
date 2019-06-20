<?
namespace Controller;
class MembreController extends Controller{

public function connexion(){
  return $this->render('layout.html','inscription.html',$params);
}

public function inscription(){
  if(!empty($_POST)){
    $erreur = array();
    $champsvides=0;
    foreach($_POST as $value){
      if(empty(trim($value))) $champsvides++;}
      if($champsvides){
    $erreur[]="Il y'a ".$champsvides." champ(s) manquant(s).";  }
    if(iconv_strlen(trim($_POST['pseudo'])<3)){
    $erreur[]="Le pseudo doit comporter plus de trois caractères.";
    }
    if(!$this->getModel()->existsPseudo($_POST['pseudo'])){
      $erreur[]="Le pseudo est déja choisi, merci d'en prendre un autre.";
    }
    if(empty($erreur)){
      $_POST['mdp']=$this->cryptMdp( $_POST['mdp']);
      $_POST['statut']=0;
      $id_user=$this->getModel()->inscription($_POST);
      $membre=$this->getModel()->select($_POST);
      $this->createSession($membre);
      $this->redirect($this->url);
    }
    }
  $params['title']='Inscription';
  $params['erreur']= (!empty($erreur)) ? implode('<br>',$erreur) : '';
  return $this->render('layout.html','inscription.html',$params);
}

  public function cryptMdp($mdp){
    $salt='Comp!iqu3';
    $mdp_new=md5($mdp.$salt);
  }

  public function createSession($membre){
    $_SESSION['membre']=$membre;
    $_SESSION['membre']->setField('mdp','');
  }

  public function deconnexion(){
    unset($_SESSION['membre']);
    $this->redirect($this->url.'membre/connexion');
  }
}
?>
