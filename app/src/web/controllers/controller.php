<?php
/*
 * Classe de base pour les controllers
*/
class Controller {
	var $vars = array();
	var $model_name;
	
	function set($vars) {
		if (!empty($vars))
			$this->vars = array_merge($this->vars, $vars);
	}
	
	function render() {
		extract($this->vars);
		$viewFileName = $this->getViewFileName(get_class($this));
		require(ROOT.'../views/'.$viewFileName);
	}
	
	function loadModel() {
		$modelFileName = $this->getModelFileName(get_class($this));
		require_once(ROOT.'../models/'.$modelFileName);
		$modelClassName = $this->getModelClassName(get_class($this));
		$this->model_name = new $modelClassName();
	}
	
	/*
	 * function helper
	 */
	static function getModelFileName($class) {
		$action = strtolower(str_replace('Ctrl', '', $class));
		return $action . '_mdl.php';
	}
	static function getModelClassName($class) {
		$action = strtolower(str_replace('Ctrl', '', $class));
		return ucfirst($action) . 'Mdl';
	}
	
	static function getViewFileName($class) {
		$action = strtolower(str_replace('Ctrl', '', $class));
		return $action . '_vw.php';
	}
	
	static function getControllerFileName($action) {
		return $action . '_ctrl.php';
	}
	static function getControllerClassName($action) {
		return ucfirst($action) . 'Ctrl';
	}
}
?>
