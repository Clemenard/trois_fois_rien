<?
require __DIR__.'/../vendor/autoload.php';
session_start();
// session_destroy();
$a = new Manager\Application;
$a->run();
?>
