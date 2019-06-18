<?
class Config {
  protected $parameters;

  public function __construct(){
    require __DIR__.'Config/parameters.php';
    $this->parameters = $parameters;

    public function get_parameters_connect(){
      return $this->parameters['connect'];
    }
    public function get_parameters_uri(){
      return $this->parameters['uri'];
    }
  }
}
?>
