<?
namespace Manager;
final class Application{
  private $controller;
  private $action;
  private $argument='';
}

public function __construct(){
  $tab=explode('/',$_SERVER['REQUEST_URI']);
  if(!empty($tab[3]) && file_exists(__DIR__ . '../../src/Controller/'.ucfirst($tab[3]).'Controller.php')){
    $this->controller = 'Controller\\'.ucfirst($tab[3]).'Controller';
  }
  else{
  $this->controller =  'Controller\ProduitController';
  }
  if(!empty($tab[4])) {
    $this->action = $tab[4];
  }
  else{
    $this->controller =  'Controller\ProduitController';
    $this->action = all();
  }
}



?>
