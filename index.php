<?php 

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
date_default_timezone_set('UTC');
error_reporting(false);
ini_set('display_errors', 0);

function __autoload($class_name) {
	include $class_name . '.php';
}

$db     	= new SDB();
$req = explode('/', $_SERVER['REQUEST_URI']);
$locator    = new IpLocator(array('ip' => end($req)), $db);
header('Content-Type: application/json');
echo $locator->getLocation();

?>
