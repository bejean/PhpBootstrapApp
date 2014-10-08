<?php
/**
 * Fonctions utilitaires de ré-initialaisation des données en sessions
 */

require_once(dirname(__FILE__) . '/domain/config.class.inc.php');
require_once(dirname(__FILE__) . '/domain/label.class.inc.php');
require_once(dirname(__FILE__) . '/domain/user.class.inc.php');


/**
 * Chargement des configurations
 */
function initConfig($force=false) {
	$config_file ="config.xml";
	$configFilePath = ROOT . "../config/" . $config_file;
	if (!file_exists($configFilePath)) {
		echo "Fichier de configuration non trouvé !";
		exit();
	}
	$xmlConfig = new Config();
	$xmlConfig->setConfigFromFile($configFilePath); 
	$xmlConfig->ensureReadyForSession();
	$_SESSION["config"] = serialize($xmlConfig);
	return $xmlConfig;
}

/**
 * Chargement des labels
 */
function initLabels($force=false) {
	if (!$force) {
		if (isset($_SESSION["labels"]) && !isset($_GET['reload'])) return unserialize($_SESSION["labels"]);
	}
	
	$labels_file = "labels.xml";
	$labelsFilePath = ROOT . "../config/" . $labels_file;
	if (! file_exists ( $labelsFilePath )) {
		echo "Fichier de labels non trouvé !";
		exit ();
	}
	$xmlLabels = new Label ();
	$xmlLabels->setConfigFromFile ($labelsFilePath);
	$xmlLabels->ensureReadyForSession();
	$_SESSION["labels"] = serialize($xmlLabels);
	return $xmlLabels;
}

/**
 * Initialisation de l'utilisateur
 */
function initUser($id='', $name='', $firstname='', $mail='', $force=false) {
	if (!$force) {
		if (empty($id) && empty($name) && empty($mail)) {
			// firstname not mandatory
			if (isset($_SESSION["user"]) && !isset($_GET['reload'])) return unserialize($_SESSION["user"]);
		}
	}
	$user = new User ($id, $name, $firstname, $mail);
	$_SESSION["user"] = serialize($user);
	return $user;
}

/**
 * Initialisation du theme pour l'action en cours
 */
 function initTheme($config, $user, $labels, $theme_name, $action, $locale) {
	require_once(ROOT . "themes/theme.class.inc.php");
	require_once(ROOT . "themes/" . $theme_name . "/theme_" . $theme_name . ".class.inc.php");
	require_once(ROOT . "themes/" . $theme_name . "/theme_" . $theme_name . "." . $action . ".class.inc.php");
	$class_name = 'Theme' . str_replace('.', '', ucwords($action)); 
	$theme = new $class_name($config, $user, $labels, $locale, $theme_name);
	return $theme;
}

?>