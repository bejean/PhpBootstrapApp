<?php
/**
 * Definition de la classe Label
 *
 */

/**
 * Oblige.
 */
require_once(dirname(__FILE__) . '/../lib/label_xml.class.inc.php');

/**
 * Classe d'accès aux labels de l'application.
 *
 * @author Taligentia
 *
 */
class Label extends XmlLabel {
		
	/**
	 * Renvoie le titre de  l'application
	 * @return string
	 */
	function getTitle() {
		$l = (string)$this->getLabelNode('//labels/title');
		return $l;
	}
	
	/**
	 * Renoie le titre du logo.
	 * @return string
	 */
	function getTitleLogo( ) {
		$l = (string)$this->getLabelNode('//labels/title_logo');
		return $l;
	}
	
	/**
	 * Renoie le alt du logo.
	 * @return string
	 */
	function getAltLogo( ) {
		$l = (string)$this->getLabelNode('//labels/alt_logo');
		return $l;
	}

}

?>