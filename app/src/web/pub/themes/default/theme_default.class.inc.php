<?php
/**
 * Classe principale des themes
 */
require_once(ROOT . "../lib/helpers.inc.php");

/**
 * Classe principale des themes
 *
 * @author Taligentia
 *
 */
class ThemeMain extends ThemeBase {

	/**
	 * @var String javascript à générer
	 */
	var $_javascript;
	/**
	 * @var String nom de la classe
	 */
	var $_class_name;
	
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
		$this->_ajaxUrl = WEBROOT . 'ajax/ajax.php';
	}
				
	function getTitle() {
		return $this->labels->getTitle();
	}
	
	function generateHead() {
		$res  =  "\n";
		$res .= '<head>' . "\n";
		
		$res .= '<title>' . $this->getTitle() . '</title>' . "\n";
		
		// description et referencement
		$res .= '<meta name="description" content="Maison des examens - Relevés de notes">' . "\n";
		$res .= '<meta name="author" content="education.gouv.fr">' . "\n";
		
		$res .= '<meta property="og:title" content="MDE" />' . "\n";	
		$res .= '<meta property="og:description" content="Maison des examens - Relevés de notes" />' . "\n";	
		$res .= '<meta property="og:type" content="website" />' . "\n";	
		$res .= '<meta property="og:url" content="http://www.siec.education.fr/" />' . "\n";	
		
		// cache et robots
		$res .=  $this->generateMeta() . "\n";
		$res .= '<meta name="robots" content="index, nofollow" />' . "\n";		
		
		// jQuery - pour la manipulation du dom et le parsing json sous ie7
		$res .= '<script type="text/javascript" src="' . $this->getJsPath() . 'jquery-2.1.1.min.js"></script>' . "\n";
		
		// Twitter bootstrap
		$res .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
		$res .= '<script type="text/javascript" src="' . $this->getBootStrapPath() . 'js/bootstrap.js"></script>' . "\n";
								
		// css 
		$res .= '<link rel="stylesheet" type="text/css" href="' . $this->getCssPath() . 'default.css" media="screen" />' . "\n";
							
		// css customize (à charger toujours en dernier)
		$res .= '<link rel="stylesheet" type="text/css" href="' . $this->getCssPath() . 'customize.css" media="screen" />' . "\n";
		
		// script
		$res .=  $this->generateScript() . "\n";

		$res .= '</head>' . "\n";
		
		return $res;
	}
	
	function generateMeta() {
		$res  =  "\n";
		$res .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>' . "\n";
		$res .= '<meta http-equiv="Cache-Control" content="no-cache" />' . "\n";
		$res .= '<meta http-equiv="Pragma" content="no-cache" />' . "\n";
		$res .= '<meta http-equiv="Cache" content="no store" />' . "\n";
		$res .= '<meta http-equiv="Expires" content="0" />' . "\n";
		return $res;
	}
	
	function generateScript() {
	
		$res  =  "\n";
		
		$ajaxUrl = $this->_ajaxUrl;
		$res .= <<<EOD
			<script type="text/javascript"><!--
				function getAjaxUrl() {
					return '$ajaxUrl';
				}
      	    //--></script>
EOD;
		return $res;
	}	
	function generateBody() {
		$res  =  "\n";
		$res .=  $this->generateHeader() . "\n";
	
		$res .=  'Mettre en place la méthode "generateBody" dans la classe ' . get_class($this) . '<br/><br/><br/><br/>';
		
		$res .=  $this->generateFooter();
		return $res;
	}

	function generateHeader() {
		$res  =  "\n";
				
		$src = $this->getImagePath() . 'logo.png';
		
		$title = $this->labels->getTitle();
		$title_img = $this->labels->getTitleLogo();
		$alt_img = $this->labels->getAltLogo();
		
		$res .= <<<EOD
			<div class='row'>
				<div class='span6'>
					<img src="$src" alt="$alt_img" title="$title_img">
				</div>
				<div class="span6 text-center">
					<h1>$title</h1>
				</div>
			</div>			
EOD;
		return $res;
	}

	function generateFooter() {
		$res  =  "\n";
		return $res;
	}	

	function generateBodyStart() {
		$res  =  "\n";
		$res .= '<body>' . "\n";
		$res .= '<div id="wrap">' . "\n";
		$res .= '<div id="main" class="container">' . "\n";
		return $res;
	}

	function generateBodyEnd() {
		$res  = "\n";
		
		$res .= '</div><!-- /.container -->' . "\n";
		$res .= '</div><!-- /.wrap -->' . "\n";
				

			$res .= '<!-- Le javascript' . "\n";
			$res .= '================================================== -->' . "\n";
			$res .= '<!-- Placed at the end of the document so the pages load faster -->' . "\n";
				
				
			$res .= <<<EOD
				<script type="text/javascript"><!--
					$(document).ready(function(){
EOD;
			
			$res .= <<<EOD
				$this->_javascript
EOD;
			
			$res .= <<<EOD
				});
				//--></script>
EOD;
		
		$res .= '</body>';
		return $res;
	}
	
}
?>
