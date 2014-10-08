<?php
/**
 * Classe theme de la page des recherches
 */
require_once(ROOT . "../lib/helpers.inc.php");

/**
 * Classe Search principale
 *
 * @author Taligentia
 *
 */
class ThemeHome extends ThemeMain implements iTheme {
	
	/**
	 * Constructeur
	 * @param object $config
	 * @param object $user
	 * @param object $labels
	 * @param string $locale
	 * @param string $name
	 */
	function __construct($config, $user, $labels, $locale, $name) {
		parent::__construct($config, $user, $labels, $locale, $name);
		$this->_class_name = get_class();
	}
			
	function generateScript() {
		$res = parent::generateScript();
		return $res;
	}	
	
	function generateBody() {
		$res = parent::generateBody();     
		return $res;
	}
}
?>
