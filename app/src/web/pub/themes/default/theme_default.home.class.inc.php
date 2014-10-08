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
		
		$res .= <<<EOD
<script type="text/javascript"><!--
		
	function hello() {
		$.ajax({
			type: "post",
			data: encodeURI($("#person_form").serialize()),
			url: getAjaxUrl() + '?action=hello',
			success: function(data) {
				$("#message").html(data.message);
			}
		});
	}
				
	$(document).on('click', '#btn_hello', function() {
		hello();
 	});
				
//--></script>
	
EOD;
	
		return $res;
	}	
	
	function generateBody() {
		$res  =  "\n";
		$res .=  $this->generateHeader() . "\n";
		$res .=  $this->generateContent() . "\n";
		$res .=  $this->generateFooter();
		return $res;
	}

	function generateContent() {
		$res  =  "\n";
		
		$class_name = get_class($this);
		
		$res .= <<<EOD
			<div class='row top30'>
				<div class='col-md-12'>
					Défini dans la classe $class_name, méthode generateContent
				</div>
			</div>
			<form id='person_form'>
			<div class='row top30'>
				<div class='col-md-12'>
					Votre nom : <input name='name' value='Dominique'>
					<button id='btn_hello' type='button' class='btn btn-sm btn-primary'>Hello</button>
				</div>
			</div>
			</form>
		
			<div class='row top30'>
				<div id='message' class='col-md-12'>
				</div>
			</div>
			
EOD;
		return $res;
	}
	
}
?>
