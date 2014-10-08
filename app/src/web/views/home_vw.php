<?php 
/**
 * View page des recherches
 */
header('Content-Type: text/html; Charset=UTF-8');
set_time_limit (300);

$theme_name = 'default';
$action = 'home';
$locale ='fr_FR';

require_once(ROOT . '../init.inc.php');

$config = initConfig();
$labels = initLabels();
$user = initUser();

$theme_action = $action;

$theme = initTheme($config, $user, $labels, $theme_name, $theme_action, $locale);

echo $theme->generateHtml();

?>