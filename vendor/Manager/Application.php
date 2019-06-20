<?
namespace Manager;
final class Application{
  private $controller;
  private $action;
  private $argument='';


public function __construct(){
  $tab=explode('/',$_SERVER['REQUEST_URI']);
  if(!empty($tab[3]) && file_exists(__DIR__ . '/../../src/Controller/'.ucfirst($tab[3]).'Controller.php')){
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
    $this->action = 'all';
  }
  if(!empty($tab[5])) {
    $this->argument = urldecode($tab[5]);
  }

}

public function run(){

  if(!is_null($this->controller)){
    $a=new $this->controller;
    if(!is_null($this->action) && method_exists($a,$this->action)){
      $action=$this->action;
      $a->$action($this->argument);
    }
    else{
      require __DIR__.'/../../src/View/404.html';
    }
  }
}
}


?>
