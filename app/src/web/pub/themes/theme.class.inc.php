<?php
/**
 * Classe de base et interface des themes
 */
interface iTheme {
	
	function generateHtml();
	
	function getThemePath();
	function getImagePath();
	function getCssPath();
	function getJsPath();
	function getBootStrapPath();
	
	function generateScript();
	function generateBody();
	function getTitle();
}

abstract class ThemeBase {
	/**
	 * @var Config
	 */
	protected $config;
	/**
	 * @var User
	 */
		protected $user;
	/**
	 * @var Label
	 */
	protected $labels;
	protected $locale;
	protected $name;
	protected $debug;

	function __construct($config, $user, $labels, $locale, $name) {
		$this->config = $config;
		$this->user = $user;
		$this->labels = $labels;
		$this->locale = $locale;
		$this->name = $name;
		$this->debug = false;
	}

	function getThemePath() {
		return 'themes/' . $this->name . '/';
	}

	function getImagePath() {
		return 'themes/' . $this->name . '/img/';
	}

	function getCssPath() {
		return 'themes/' . $this->name . '/css/';
	}

	function getJsPath() {
		return 'themes/' . $this->name . '/js/';
	}
	
	function getBootStrapPath() {
		return 'themes/' . $this->name . '/bootstrap-3/';
	}
	
	function setDebug($debug) {
		$this->debug = debug;
	}

	function getHumanDate($date, $format = 'd/m/Y H:i:s') {
		return date_format(date_create($date), $format);
		//2012-03-28T13:21:48Z
	}

	function generateHtml() {
		$res =  $this->generateHtmlStart();
		$res .= $this->generateHead();
		$res .= $this->generateBodyStart();
		$res .= $this->generateBody();
		$res .= $this->generateBodyEnd();
		$res .= $this->generateHtmlEnd();
		return $res;
	}
	
	function generateHead() {return '';}
	function generateBody() {return '';}
	
	function generateHtmlStart() {
		$res =  '<!DOCTYPE HTML>' . "\n";
		$res .= '<html lang="fr">';
		return $res;
	}
	
	function generateHtmlEnd() {
		$res  =  "\n";
		$res .= '</html>';
		return $res;
	}
	
	function generateBodyStart() {
		$res  =  "\n";
		$res .= '<body>' . "\n";
		return $res;
	}
	
	function generateBodyEnd() {
		$res  = "\n";
		$res .= '</body>';
		return $res;
	}
}
?>