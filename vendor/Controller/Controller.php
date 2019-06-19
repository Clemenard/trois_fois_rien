<?
namespace Controller;
use Config, Model;

class Controller{
protected $model,$url;
public function __construct(){
  $classModel=str_replace('Controller','Model',get_called_class());
  $this->model=new $classModel;
  $config=new Config;
  $this->url=$config->getParametersUri();
}
public function getModel(){
  return $this->model;
}
public function redirect($adresse){
  header('location;'.$adresse);
}
public function render($layout,$view,$params){
  $dirView = __DIR__.'/../../src/View/';
  $dirFile = $this->getModel()->getTableName;
  $pathView=$dirView.$dirFile.'/'.$view;
  $pathLayout=$dirView.$layout;
  $params['url']=$this->url;
  $params['nb']=0;
  if(isset($_SESSION['panier']) && count($_SESSION['panier']['id_produit']>0)){
  $params['nb']=array_sum($_SESSION['panier']['quantite']);
  }
  extract('params');
  ob_start();
  require $pathView;
  $content=ob_get_clean();
  require $pathLayout;
  return ob_end_flush();
}
}
?>
