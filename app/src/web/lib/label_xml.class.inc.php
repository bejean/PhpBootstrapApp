<?php
/**
 * Definition de la classe Label
 *
 */

/**
 * Oblige.
 */
require_once('config_xml.class.inc.php');

/**
 * Classe d'accès aux labels de l'application.
 *
 * @author Taligentia
 *
 */
class XmlLabel extends XmlConfig {
	
	/**
	 * @var boolean Pour tracer les appels (debug)
	 */
	var $_trace = false;
	/**
	 * @var boolean Pour afficher les labels non renseignes.
	 */
	var $_show_key = false;
	
	/**
	 * Initialisation
	 * 
	 * @see XmlConfig::setConfigFromFile()
	 * @param string $configFilePath chemin d'accès.
	 */
	function setConfigFromFile($configFilePath) {
		parent::setConfigFromFile($configFilePath);
		$this->_trace = $this->getConfigNodeValueBoolean('//labels/trace', false);
		$this->_show_key = $this->getConfigNodeValueBoolean('//labels/show_key', false);
	}
		
	/**
	 * Methode de verification de la présence du label.
	 * @param string $key La clé associée au label
	 * @param string $l le label ou nul si abasent
	 * @return string le label, <$key>{TODO} sinon
	 */
	private function addTodoAndTrace($key, $l) {
		if ($this->_trace && $l != null) $l = '*' . $l;
		return ($l == null) ? $key.'{TODO}'	: $l;
	}
	
	/**
	 * Methode de formatage des labels. Ne traite que le saut de ligne.
	 * @param string $l le label ou nul si abasent
	 * @return string le label
	 */
	private function formatString($l) {
		return str_replace("\\n", "\n", $l);
	}
	
	/**
	 * Modification du label en mode trace
	 * Methode de verification de la présence du label.
	 * @param string $key La clé associée au label
	 * @param string $l le label ou nul si abasent
	 * @return string le label avec une etoile si le label n'est pas null.
	 */
	private function addTrace($key, $l) {
		if ($this->_trace && $l != null) $l = '*' . $l;
		return $l;
	}
	
	/**
	 * Recherche un label pour un xpath donné. Peut être debrayé pour afficher la clè à la place.
	 * @param string $xpath
	 * @return string le label recherché.
	 */
	function getLabelNode($xpath) {
		if ($this->_show_key) return $xpath;
		$node = (string)$this->getConfigNode($xpath);
		return htmlspecialchars((string)$node, ENT_QUOTES, 'UTF-8');
	}
	
	/**
	 * Retourne la valeur par defaut si la chaine passée en parametre est vide.
	 * @param string $l
	 * @param string $default
	 * @return string
	 */
	function setDefault( $l, $default ) {
		return (empty($l) || strpos($l, '{TODO}')!==FALSE) ? $default	: $l;
	}
}

?>