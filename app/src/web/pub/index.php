<?php
session_set_cookie_params(0); 
session_start('default');

/*
 * Gestion du back
 */
// if (isset($action)) {
//  	if ($action == 'search' || $action == 'queries') {
//  		if (empty($_GET)) {
// 	 		if (!empty($_POST)) {
// 				$_SESSION['POST_' . $action] = $_POST;
// 				header('Location: ' . $action . '.php');
// 			} else {
// 				if (!empty($_SESSION['POST_' . $action])) {
// 					$_POST = $_SESSION['POST_' . $action];
// 				}
// 			}
//  		}
// 	}
// }

define('ROOT', dirname(__FILE__) . '/');
require_once(ROOT . '../lib/helpers.inc.php');

define('WEBROOT', getRootPath($_SERVER['SCRIPT_NAME']));

require_once(ROOT.'../models/model.php');
require_once(ROOT.'../controllers/controller.php');
require_once(ROOT.'../init.inc.php');

if (empty($action)) $action = getRequestParam('action');

$config = initConfig(true);
initLabels(true);

if (empty($action)) {
	$action = 'home';
}

require('../controllers/'.Controller::getControllerFileName($action));

$controllerClassName = Controller::getControllerClassName($action);
$controller = new $controllerClassName();
if (method_exists($controller, 'process')) {	
	$extra = '';
	$controller->process($extra);
}
else {
	echo 'Erreur controlleur !';
	quit();
}
?>
