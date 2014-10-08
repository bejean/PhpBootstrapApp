<?php
/**
 * Controleur page de recherche
 */
require_once(ROOT . '../lib/helpers.inc.php');
require_once(ROOT . '../init.inc.php');

class HomeCtrl extends Controller {
	function process($extra='') {	
		
		$this->loadModel();	
		$d = array();
		
		// render home
		$this->set($d);
		$this->render();
	}
}
?>