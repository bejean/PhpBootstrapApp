<?php
/**
 * Traitements Ajax
 *
 * @author 
 * @version 1.0
 * @package 
 */

session_start('men');
header("Content-type: application/json");

define('ROOT', dirname(__FILE__) . '/../');

/**
 * Oblige.
 */
require_once(ROOT . '../lib/helpers.inc.php');

define('WEBROOT', getRootPath(substr(getRootPath($_SERVER['SCRIPT_NAME']), 0, -1)));

/**
 * Oblige.
 */
require_once(ROOT . '../init.inc.php');

$config = initConfig();
$user = initUser();
$action = getRequestParam("action");

/**
 * Une action
 */
if ($action=="hello") {
	$name = getRequestParam("name");
	
	$arr['status'] = 'success';
	$arr['message'] = 'hello ' . $name;
	$res = json_encode($arr);
	print ($res);
}

?>