<?
class Autoload{
  public static function inclusion_automatique($className){
    $tab = explode('\\',$className);
    if($tab[0]=='Manager'|| ($tab[0]=='Model' && $tab[1]=='Model') || ($tab[0]=='Controller' && $tab[1]=='Controller')|| ($tab[0]=='Entity' && $tab[1]=='Entity')){
        $path= __DIR__ .'/' . implode('/',$tab) . '.php';
    }
    else{
      $path= __DIR__ .'/../src/' . implode('/',$tab) . '.php';
    }
    require $path;
  }
}

// j'indique la méthode qui va se déclencher au moment d'un new (La méthode doit être statique)
spl_autoload_register(array('Autoload','inclusion_automatique'));
date_default_timezone_set('Europe/Paris');




// Constantes de site
define('SALT','Comp!iqu3');

// Initialisation de variables
$content = '';
$left_content = '';
$right_content = '';
?>
