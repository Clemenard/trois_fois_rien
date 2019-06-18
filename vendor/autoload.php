<?
class Autoload{
  public static function inclusion_automatique($className){
    $tab = explode('\\',$className);
    if($tab[0]=='Manager'|| ($tab[0]=='Model' && $tab[1]=='Model') || ($tab[0]=='Controller' && $tab[1]=='Controller')){
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
require_once('functions.php');
date_default_timezone_set('Europe/Paris');

// Session
session_start();



// Constantes de site
define('URL','/boutique_oo/');
define('SALT','Comp!iqu3');

// Initialisation de variables
$content = '';
$left_content = '';
$right_content = '';
?>
