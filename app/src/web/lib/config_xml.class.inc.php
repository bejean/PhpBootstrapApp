<?php
/**
 * Classe utilitaire de gestion des fichiers de configuration
 * 
 * @author Taligentia 
 * @version 1.0
 * @package lib
 */

class XmlConfig {
	// ne peut pas être mis en session sous forme xml !!!
	// on utilisera les string

	/**
	 * @var simple_xml La représetation xml objet du fichier de configuration commun
	 */
	private $_x_common = null;
	/**
	 * @var simple_xml La représetation xml objet du fichier de configuration principal
	 */
	private $_x = null;
	/**
	 * @var simple_xml La représetation xml objet du fichier de configuration secondaire
	 */
	private $_x2 = null;
	/**
	 * @var string La représetation xml string du fichier de configuration commun
	 */
	private $_str_x_common  = null;
	/**
	 * @var string La représetation xml string du fichier de configuration principal
	 */
	private $_str_x  = null;
	/**
	 * @var string La représetation xml string du fichier de configuration secondaire
	 */
	private $_str_x2 = null;
	/**
	 * @var string Le chemin du fichier de configuration
	 */
	protected $_configFilePath = null;
	
	/**
	 * Assure que les versions xml objet sont à l'image des version xml string 
	 * Imperatif apres une récupération en session
	 * @param 
	 * @return
	 */
	private function ensureValid() {
		if ($this->_x_common==null && $this->_str_x_common!=null) $this->_x_common = simplexml_load_string($this->_str_x_common);
		if ($this->_x==null && $this->_str_x!=null) $this->_x = simplexml_load_string($this->_str_x);
		if ($this->_x2==null && $this->_str_x2!=null) $this->_x2 = simplexml_load_string($this->_str_x2);
	}

	/**
	 * Assure que les versions xml sting sont à l'image des version xml objet et
	 * destruction des version xml objet 
	 * Imperatif avant une mise en session
	 */
	function ensureReadyForSession() {
		if ($this->_x_common!=null) {
			$this->_str_x_common = $this->_x_common->asXml();
			$this->_x_common=null;
		}
		if ($this->_x!=null) {
			$this->_str_x = $this->_x->asXml();
			$this->_x=null;
		}
		if ($this->_x2!=null) {
			$this->_str_x2 = $this->_x2->asXml();
			$this->_x2=null;
		}
	}
	
	/**
	 * Charge les fichiers xml de configuration 
	 * @param string $configFilePath le fichier xml principal
	 */
	function setConfigFromFile($configFilePath) {
		$this->_configFilePath = $configFilePath;
		$this->_x_common = null;
		$this->_x = null;
		$this->_x2 = null;
		if (!is_file($configFilePath)) return false;
				
		$this->_x = simplexml_load_file($configFilePath);
		$this->_str_x = $this->_x->asXml();
		$configFilePath2 = dirname ($configFilePath) . '/' . basename ($configFilePath,".xml") . '-2.xml';
		if (is_file($configFilePath2)) {
			$this->_x2 = simplexml_load_file($configFilePath2);
			$this->_str_x2 = $this->_x2->asXml();
		}
		
		// common ?
		$common = $this->getConfigNodeValue('//config/common');
		if (!empty($common)) {
			$configFilePathCommon = dirname ($configFilePath) . '/' . $common;
			if (is_file($configFilePathCommon)) {
				$this->_x_common = simplexml_load_file($configFilePathCommon);
				$this->_str_x_common = $this->_x_common->asXml();
			}
		}
	}
	
	/**
	 * Lecture d'un noeud xml de la configuration 
	 * Renvoit le premier noeud xml correspondant au chemin xpath
	 * @param string $xpath le chemin xpath du noeud à récupérer
	 * @return simple_xml  
	 */
	function getConfigNode($xpath) {
		$this->ensureValid();
		if ($this->_x==null) return null;
		if ($this->_x2!=null) {
			$nodes = $this->_x2->xpath($xpath);
			if ($nodes) return $nodes[0];
		}
		$nodes = $this->_x->xpath($xpath);
		if ($nodes) return $nodes[0];

		if ($this->_x_common!=null) {
			$nodes = $this->_x_common->xpath($xpath);
		}
		
		if (!$nodes) return null;
		return $nodes[0];
	}

	/**
	 * Lecture d'un tableau de noeuds xml de la configuration 
	 * Renvoit les noeuds xml correspondant au chemin xpath
	 * @param string $xpath le chemin xpath du noeud à récupérer
	 * @return simple_xml renvoit un tableau de noeuds xml 
	 */
	function getConfigNodes($xpath) {
		$this->ensureValid();
		if ($this->_x==null) return false;
		if ($this->_x2!=null) {
			$nodes = $this->_x2->xpath($xpath);
			if ($nodes) return $nodes;
		}
		
		$nodes = $this->_x->xpath($xpath);
		if ($nodes) return $nodes;
		
		if ($this->_x_common!=null) {
			$nodes = $this->_x_common->xpath($xpath);
		}
		
		return $nodes;
	}
	
	/**
	 * Lecture d'une valeur d'un noeuds xml de la configuration 
	 * Renvoit la valeur du noeud xml correspondant au chemin xpath
	 * @param string $xpath le chemin xpath du noeud à récupérer
	 * @param string $default valeur par defaut
	 * @return string renvoit la valeur du noeud xml
	 */
	function getConfigNodeValue($xpath, $default='') {
		$node = $this->getConfigNode($xpath);
		if ($node==null) {
			if (!empty($default)) return $default;
			return false;
		}
		$ret = (string)$node;
		//if (empty($ret)) $ret=$default;
		if (empty($ret) && $ret!='0') $ret=$default;
		return $ret;
	}
	
	/**
	 * Lecture d'une valeur d'un noeuds xml de la configuration 
	 * Renvoit la valeur du noeud xml correspondant au chemin xpath
	 * @param string $xpath le chemin xpath du noeud à récupérer
	 * @param string $default valeur par defaut
	 * @return numeric renvoit la valeur du noeud xml
	 */
	function getConfigNodeValueNumeric($xpath, $default='') {
		$ret = $this->getConfigNodeValue($xpath, $default);
		if (!is_numeric($ret)) {
			if (!empty($default)) return $default;
			return false;		
		}
		return $ret;
	}
		
	/**
	 * Lecture d'une valeur d'un noeuds xml de la configuration 
	 * Renvoit la valeur du noeud xml correspondant au chemin xpath
	 * @param string $xpath le chemin xpath du noeud à récupérer
	 * @param string $default valeur par defaut
	 * @return boolean renvoit la valeur du noeud xml
	 */
	function getConfigNodeValueBoolean($xpath, $default='') {
		$value = $this->getConfigNodeValue($xpath);
		if (!$value && !empty($default)) {
			return $default;
		}
		$value = trim(strtolower($value));
		return ($value=='1' || $value=='true');
	}
	
	/**
	 * Remplace un noeud d'un oblet xml par un autre noeud
	 * @param string $xpath le chemin xpath du noeud à récupérer
	 * @param simple_xml $xml un objet xml
	 */
	function replaceNode($xpath, $xml) {
		$domToChange = dom_import_simplexml($this->getConfigNode($xpath));
		$domReplace  = dom_import_simplexml(simplexml_load_string($xml));
		$nodeImport  = $domToChange->ownerDocument->importNode($domReplace, TRUE);
		$domToChange->parentNode->replaceChild($nodeImport, $domToChange);
	}
}

?>