<?
namespace Manager;
use PDO, Config;

class PDOManager{
  private static $instance = null;
  private function __construct(){}
  private function __clone(){}
    public static function getInstance(){
      if(is_null(self::$instance)){
        self::$instance = new self;
      }
      return self::$instance;
    }

    public function getPdo(){
      require __DIR__.'/../../app/Config.php';
      $config = new Config;
      $connect = $config->getParametersConnect();
      return new PDO(
        'mysql:host='.$connect['host'].';dbname='.$connect['dbname'],$connect['login'],$connect['password'],array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
          PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
      );
    }
}

?>
