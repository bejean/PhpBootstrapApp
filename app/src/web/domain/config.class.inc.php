<?php
/**
 * Definition de la classe Config
 *
 */

/**
 * Oblige.
 */
require_once(dirname(__FILE__) . '/../lib/config_xml.class.inc.php');
// /**
//  * Oblige.
//  */
// require_once(dirname(__FILE__) . '/../../lib/solr.class.inc.php');
// /**
//  * Oblige.
//  */
// require_once(dirname(__FILE__) . '/db.class.inc.php');
// /**
//  * Oblige.
//  */
// require_once(dirname(__FILE__) . '/dbOracle.inc.php');
// /**
//  * Oblige.
//  */
// require_once(dirname(__FILE__) . '/dbMySql.inc.php');
// /**
//  * Oblige.
//  */
// require_once(dirname(__FILE__) . '/solr_request.class.inc.php');
// /**
//  * Oblige.
//  */
// require_once(dirname(__FILE__) . '/../models/model.php');
// /**
//  * Oblige.
//  */
// require_once(dirname(__FILE__) . '/../models/search_mdl.php');

/**
 * Classe d'accès à la configuration de l'application.
 *
 * @author Taligentia
 *
 */
class Config extends XmlConfig {
	
	/**
	 * @var string option de recherche par defaut.
	 */
	var $_default_search_option = null;
	
	/**
	 * Initialise la configuration
	 * @see XmlConfig::setConfigFromFile()
	 * @param string $configFilePath le chemin d'accès au fichier.
	 */
	function setConfigFromFile($configFilePath) {
		parent::setConfigFromFile($configFilePath);
	}
	
	/**
	 * Renvoie le no de version.
	 * @return string
	 */
	function getVersion() {
		return (string)$this->getConfigNode('//config/version');
	}
	
	/**
	 * Renvoie le champ utilise en recherche simple.
	 * @return string
	 */
	function getSimpleSearchField() {
		return (string)$this->getConfigNode('//config/search/simple_search_field');
	}

	/**
	 * Renvoie l'action pour la recherche.
	 * @param string $default search par defaut.
	 * @return string
	 */
	function getDefaultAction($default='search') {
		return (string)$this->getConfigNode('//config/default_action', $default);
	}
	
	/**
	 * rentourne l'ensemble des champs utilisé en recherche.
	 * @return Array 
	 */
	function getSearchFields() {
		$nodes = $this->getConfigNodes('//config/search/fields/field');
		$ret = array();
		foreach ($nodes as $node){
			$ret[] = (string)$node['name']; 	
		}
		return $ret;
	}
	
	/**
	 * Renvoie, pour un champ de recherche, sa configuration
	 * @param string $fieldName
	 * @return simple_xml
	 */
	function getSearchFieldConfig( $fieldName ) {
		return $this->getConfigNode('//config/search/fields/field[@name="'. $fieldName . '"]');
	}
	
	/**
	 * Renvoie le repertoire à utilsier pour les fichiers temporaires.
	 * @return string
	 */
	function getTmp() {
		$file = (string)$this->getConfigNode('//config/repertoires/rep[@id="tmp"]/file');
		$absolu = $this->getConfigNodeValueBoolean('//config/repertoires/rep[@id="tmp"]/absolu');
		if( !$absolu && !empty($file))
			$file = ROOT . "/" .$file;
		return $file;
	}
	
	/**
	 * Renvoie un fichier temporaire
	 * @param string $prefixe
	 * @return string
	 */
	function getTmpFileName($prefixe="tmp") {
		return tempnam( $this->getTmp(),$prefixe );
	}
	
	/**
	 * Renvoie l'accès au repertoire Oracle qui contient les templates de script.
	 * @return string
	 */
	function getOracle() {
		$file = $this->getConfigNode('//config/repertoires/rep[@id="oracle"]/file');
		$absolu = $this->getConfigNodeValueBoolean('//config/repertoires/rep[@id="oracle"]/absolu');
		if( !$absolu )
			$file = ROOT . "/" .$file;
		return $file;
	}
	
	/**
	 * Renvoie le nom du fichier de log.
	 * @return string
	 */
	function getLogFile() {
		$file = $this->getConfigNode('//config/repertoires/rep[@id="logs"]/file');
		$absolu = $this->getConfigNodeValueBoolean('//config/repertoires/rep[@id="logs"]/absolu');
		if( !$absolu )
			$file = ROOT . "/" .$file;
		return $file;
	}
	
	/**
	 * Renvoie la cle google maps pour l'accès à partir du browser.
	 * @return string
	 */
	function getApiKey() {
		$key = (String)$this->getConfigNode('//config/carte/apiKey');
		return $key;
	}

	/**
	 * Renvoie la cle google map à utiliser au niveau serveur.
	 * @return string
	 */
	function getApiKeyStatic() {
		$key = (String)$this->getConfigNode('//config/carte/apiKeyStatic');
		return $key;
	}

	/**
	 * renvoie le repertoire à utiliser pour le cache carto.
	 * @return string
	 */
	function getCachePath() {
		$key = (String)$this->getConfigNode('//config/carte/cache_path');
		return $key;
	}
	
	/**
	 * renvoie la taille à utiliser pour les cartes statiques.
	 * @return string
	 */
	function getCarteDimension() {
		$key = (String)$this->getConfigNode('//config/carte/dimension');
		return $key;
	}
	
	/**
	 * Renvoie le niveu de zoom pour les cartes statique.
	 * @return string
	 */
	function getCarteZoom() {
		$key = (String)$this->getConfigNode('//config/carte/zoom');
		return $key;
	}
	
	/**
	 * renvoie la liste des champs accessibles.
	 * @return array
	 */
	function getResultFieldAvailable() {
		$node = (string)$this->getConfigNode('//config/search/results/available');
		$node = str_replace("\n", '', $node);
		$node = str_replace("\t", '', $node);
		$node = str_replace(' ', '', $node);
		return array_map('trim',explode(",",$node));
	}

	/**
	 * Renvoie la liste des champs qui ne peuvent pas être triés.
	 * @return array
	 */
	function getResultFieldNotSortable() {
		$node = (string)$this->getConfigNode('//config/search/results/not_sortable');
		return array_map('trim',explode(",",$node));
	}
	
	/**
	 * Renvoie la liste des champs qui ne peuvent être séllectionnés pour être affichés.
	 * @return array
	 */
	function getResultFieldSelected() {
		$nodes = $this->getConfigNodes('//config/search/results/fields/field');
		$ret = array();
		foreach ($nodes as $node) {
			$ret[] = (string)$node['name'];
		}
		return $ret;
	}
	
	/**
	 * Renvoiele nombre maximum de champs pouvant être affichés en liste de resultat.
	 * @param String $default
	 * @return string
	 */
	function getResultFieldSelectedMaxItems($default) {
		return $this->getConfigNodeValueNumeric('//config/search/results/selected_max_items', $default);	
	}
	
	/**
	 * Renvoie la liste des champs pouvant être sélectionnés en extraction.
	 * @param string $classe classe parmi {uai,zone, ...}
	 * @return array
	 */
	function getExtractOptionFields($classe) {
		$nodes = $this->getConfigNodes("//config/search/extraction/options/$classe/fields/field");
		$ret = array();
		foreach ($nodes as $node) {
			$ret[(string)$node['name']] = array ('name' => (string)$node['name'], 'sortable' => (string)$node['sortable'], 'allow_label' => (string)$node['allow_label']);
		}
		return $ret;
	}
	
	/**
	 * Renvoie la liste triée des champs pouvant être extraits pour une classe.
	 * @param string $classe
	 * @return multitype:string Ambigous <multitype:string > 
	 */
	function getExtractField($classe) {
		$ret = array();
		foreach ($this->getExtractOptionFields($classe) as $elem) {
			$ret[] = $elem['name'];
			if( $elem['allow_label'])
				$ret[] = $elem['name'].'_libe';
		}
		return $ret;
	}
	
	/**
	 * Renvoie, pour l'extraction, la balise (csv ou xml) à utiliser.
	 * @param string $classe une classe
	 * @param string $fieldName un champ
	 * @param string $balise
	 * @return string
	 */
	function getFieldBalise( $classe,$fieldName,$balise ) {
		$l = $this->getConfigNodes('//config/search/extraction/mapping/'. $classe.'/fields/'.$fieldName . '/'.$balise);
		return ($l == null) ? 'NOCONFIG{'.$classe.':'.$fieldName.'}'	: (String)$l[0];
	}
	
	/**
	 * Renvoie, pour l'extraction, les balises (csv ou xml) à utiliser.
	 * @param string $classe une classe
	 * @param string $t_fieldName une liste de champs.
	 * @param string $balise
	 * @return string
	 */
		function getTabFieldBalise($classe,$t_fieldName,$balise) {
		$ret = array();
		foreach ($t_fieldName as $fieldName) {
			$ret[$fieldName] = $this->getFieldBalise($classe, $fieldName, $balise);
		}
		return $ret;
	}
	
	/**
	 * Renvoie, pour l'extraction, les champs à extraire
	 * @param string $name
	 * @return array liste de champs 
	 */
	function getDetailFields() {
		$nodes = $this->getConfigNodes("//config/search/detail/options/merefille/fields/field");
		$ret = array();
		foreach ($nodes as $node) {
			$name = (string)$node['name'];
			$ret[] = $name;
			if( (integer)$node['allow_label'] )
				$ret[] = $name.'_libe';
		}
		return $ret;
	}
	
	/**
	 * Renvoie l'ensemble des options pour les résultats.
	 * @return simple_xml
	 */
	function getSearchOptions() {
		return $this->getConfigNode('//config/search/results')->asXML();
	}
	
	/**
	 * Positionne et modifie les options d'extraction pour les conserver tout au long de la session
	 * @param string $option
	 */
	function setSearchOptions($option) {
		if (!empty($this->_default_search_option)) $this->_default_search_option = $this->getSearchOptions();
		if (!empty($option)) {
			$this->replaceNode('//config/search/results', $option);
			return;
		}
		if (!empty($this->_default_search_option)) {
			$this->replaceNode('//config/search/results', $this->_default_search_option);
		}
	}
	
	/**
	 * Renvoie la liste des champs pouvant être demandés à Solr (optimisation).
	 * @return array liste des champs.
	 */
	function getSolrSearchFields() {
		$solrfields = array( 
				'numero_uai',

				'specificite_uai', 'type_zone_uai','appellation_officielle',
				'denomination_principale_uai','adresse_uai',
				'code_postal_uai','localite_acheminement_uai',
				'numero_telephone_uai','mel_uai','site_web',
				'point_x','point_y','point',

				'score'
		);
		$columns = $this->getConfigNodes('//search/results/fields/field');
		foreach ($columns as $column) {
			if (!in_array((string)$column['name'],$solrfields )) $solrfields[] = (string)$column['name'];
		}
		return $solrfields;
	}
	
	/**
	 * Renvoie le nombre maximum d'uai pouvant être extraits.
	 * @return integer
	 */
	function getMaxUais() {
		return $this->getConfigNodeValueNumeric('//config/search/extraction/max_uais',1000);
	}
	
	/**
	 * Renvoie l'ensemble de la configuration pour les facettes
	 * @return simple_xml
	 */
	function getFacetConfig() {
		return $this->getConfigNodes('//config/search/facets/field[active="true"]');
	}

	/**
	 * Renvoie l'url de la page d'aide.
	 * @param string $page
	 * @return string
	 */
	function getHelpUrl($page='default') {
		$url = $this->getConfigNodeValue('//config/help/' . $page);
		if (empty($url) && $page!='default') $url = $this->getConfigNodeValue('//config/help/default');
		return $url;
	}
	
	/**
	 * Renvoie l'url de la page de retour.
	 * @param string $page
	 * @return string
	 */
		function getQuitUrl() {
		$url = $this->getConfigNodeValue('//config/quit_url');
		return $url;
	}
	
	/**
	 * Renvoie une liste des champs facettes.
	 * @return string liste de facettes separées par des ,
	 */
	function getFacetFieldList() {
		$ret = '';
		$facets = $this->getFacetConfig();
		if ($facets) {
			foreach ($facets as $facet) {
				if (!empty($ret)) $ret .= ',';
				$ret .= (string)$facet['name'];
			}
		}
		return $ret;
	}	
	
	/**
	 * Renvoie l'existance du champ en tant que facette
	 * @param string $facetfield
	 * @return boolean True si la facette est déclarée.
	 */
	function isFacet($facetfield) {
		return $this->getConfigNodeValue('//config/search/facets/field[@name="'. $facetfield . '"]');
	}
	
	/**
	 * Renvoie l'état d'une facette tel que defini en config
	 * @param string $facetfield
	 * @return boolean True si la facette doit être "ouverte".
	 */
	function isFacetOpen($facetfield) {
		return $this->getConfigNodeValueBoolean('//config/search/facets/field[@name="'. $facetfield . '"]/open');
	}
	
	/**
	 * Renvoie le nom du sous-champs (hierarchie)
	 * @param string $facetfield
	 * @return string nom du sous champ
	 */
	function getFacetSubField($facetfield) {
		return $this->getConfigNodeValue('//config/search/facets/field[@name="'. $facetfield . '"]/hierarchical');
	}
	
	/**
	 * Renvoie la zone de saisie d'une facette tel que defini en config
	 * @param string $facetfield
	 * @return boolean True si la facette a un champ de saisie.
	 */
	function isFacetWithInput($facetfield) {
		return $this->getConfigNodeValueBoolean('//config/search/facets/field[@name="'. $facetfield . '"]/input', false);
	}

	/**
	 * Renvoie la normalisation d'une facette tel que defini en config
	 * @param string $facetfield
	 * @return boolean True si la facette est normalisée.
	 */
	function isFacetNormalize($facetfield) {
		return $this->getConfigNodeValueBoolean('//config/search/facets/field[@name="'. $facetfield . '"]/normalize', false);
	}
	
	/**
	 * Renvoie l'adapteur de base de donnée.
	 * @return dbMen .
	 */
	function getDbAdapteur() {
		$adapter = $this->getConfigNodeValue('//config/db/adapter');
		$host = $this->getConfigNodeValue('//config/db/host');
		$port = $this->getConfigNodeValue('//config/db/port');
		$dbname = $this->getConfigNodeValue('//config/db/dbname');
		$username = $this->getConfigNodeValue('//config/db/username');
		$password = $this->getConfigNodeValue('//config/db/password');
		$db = false;
		if( $adapter == 'mysql')
			$db = new  DbMySql($adapter, $host,  $dbname, $username, $password);
		if( $adapter == 'oci8') {
			if (!empty($port)) $host .= ':' . $port;
			$sqlContact = $this->getConfigNodeValue('//contact/sql');
			$db = new  DbOracle($adapter, $host,  $dbname, $username, $password,$sqlContact);
		}
		return $db;
	}
	
	/**
	 * Renvoie l'email de contact pour un uai. Si l'uai est vide ou n'existe pas, Renvoie le contact par défaut.
	 * @param $numero_uai le  numero de l'uai pour lequel il faut rechercher le contact.
	 *  Si null, renvoie le contact par defaut
	 *
	 */
	function getMailContactByUai ($numero_uai='' ) {
		$email = null;
		if( $numero_uai ) {
			$db = $this->getDbAdapteur();
			if ($db) {
				$email = $db->getMailContactByUai( $numero_uai );
			}
		}
		//if( !$email ) {
		//	$email = $this->getConfigNodeValue('//config/contact_email_to');
		//}
		return $email;
	}
	
	/**
	 * Est-ce qu eles logs doivent s'afficher à l'ecran ?
	 * @return boolean
	 */
	function isLogOnScreen() {
		return $this->getConfigNodeValueBoolean('//config/log/screen') && $_SESSION['js']!='0';
	}
	
	/**
	 * Est-ce qu eles logs doivent s'enregistrer au niveau système ?
	 * @return boolean
	 */
	function isLogSystem() {
		return $this->getConfigNodeValueBoolean('//config/log/system');
	}
	
	/**
	 * Est-ce qu eles logs doivent s'enregistrer dans un fichier ?
	 * @return boolean
	 */
		function isLogFile() {
		return $this->getConfigNodeValueBoolean('//config/log/file');
	}
	
	/**
	 * Reinitialise le buffer de logs
	 */
	function startLog() {
		$_SESSION['logs'] = array();
	}
	
	/**
	 * Ajoute un log, le formate. En mode fichier ou systeme, l'emet imédiatement.
	 * @param array $log
	 */
	private function addLog($log) {
		$user = initUser();
		$log['user'] = ( !empty($user) && $user->isLogged() ) ? $user->getId() : '';
		$log['timestamp'] = time();
		$_SESSION['logs'][] = $log;
			if( $this->isLogSystem() ) {
			$mess = Config::formatLog($log);
			openlog('IBCE', LOG_NDELAY, LOG_USER);
			syslog(LOG_NOTICE,$mess);
			closelog();
		}
		if( $this->isLogFile() ) {
			$mess = Config::formatLog($log);
			$logfile = $this->getLogFile();
			$file=fopen($logfile,"a");
			fwrite( $file,$mess."\n" );
			fflush($file);
		}
	}
	
	/**
	 * Renvoie le buffer de logs
	 * @return array liste de logs
	 */
	private function getLogs() {
		return $_SESSION['logs'];
	}
	
	/**
	 * Formate un log.
	 * @param array $log
	 * @return string
	 */
	static function formatLog($log) {
		return sprintf( "%s;%s;%s;%s;%s;%s;%s;%s;%s;%s",
				date(DATE_ISO8601 ,$log['timestamp'] ),
				$log['user'],
				$log['action'],
				$log['sub_action'],
				$log['mode'],
				$log['fields'],
				$log['facettes'],
				$log['queryid'],
				$log['numFound'],
				$log['time']
		);
	}
	
	/**
	 * Renvoie la liste des logs sous format html
	 * @return string
	 */
	function getLogsInHtml() {
		$tohm =  function ($log) { return Config::formatLog($log); };
		$html  = '<ul><li>';
		$html .= implode( '</li><li>',array_map( $tohm,$this->getLogs()) );
		$html .= '</li></ul>';
	
		$logs = array();
		$logs['logs'] = $this->getLogs();
		$logs['html'] = $html;
		return $logs;
	}
	
	/**
	 * formate une liste de tables d'association en echappant certains carateres
	 * @param array $tab
	 * @return string
	 */
	private function mapToString( $tab ) {
		$str = '';
		if( !empty( $tab )) {
			$f_quote = function($v) { 
				$v = strtr( $v, array('"' => '\"'));
				return '"'.$v.'"';
			} ;
			foreach($tab as $field => $value ) {
				if( !is_array($value) )
					$v = $value;
				else
					$v = '['.implode(',',array_map($f_quote,$value)).']';
				$str .= ','.$field.':'.$v;
			}
			$str = substr($str,1);
		}
		return $str;
	}
	
	/**
	 * Logue une requete simple
	 * @param SolrRequest $request
	 * @param String $action  l'action (search,extract,...)
	 * @param String $sub_action
	 * @param String $mode
	 * @param String $query_id identifiant de requete.
	 * @param Integer $numFound Nombre d'elements trouvés
	 * @param Integer $time temps en millissecondes pour executer l'action
	 */
	function logRequest($request,$action,$sub_action,$mode,$query_id,$numFound, $time) {
		$log = array();
		$log['action'] =  $action;
		$log['sub_action'] =  $sub_action;
		$log['mode'] = $mode;
		$log['queryid'] = ( $query_id != null ) ? ''.$query_id : '';
		$log['numFound'] = ( $numFound != -1 ) ? ''.$numFound.'' : 'inconnu';
		$log['time'] = ( $time != -1 ) ? ''.$time.'' : 'inconnu';
		
		$log['facettes'] = $this->mapToString($request->getFacets());
		$fields = $request->getForm();
		if( $request->getQueryField() != null ) {
			$fields[$request->getQueryField()] = array( $request->getQuery() );
		}
		$log['fields'] = $this->mapToString($fields);
		$this->addLog($log);
	}
	
	/**
	 * logue une requete complexe.
	 * @param UserRequestState $userRequest l'etat à loguer
	 * @param Solr $solr 
	 * @param solr_response $response
	 * @param String $query_id identifiant de requete.
	 */
	function logUserRequest(UserRequestState $userRequest,$solr,$response,$query_id) {
		$post = $userRequest->getPostQuery();
		if( $response != null ) {
			$rep = $response->getJsonResponse();
			$time = $rep->responseHeader->QTime;
			$numFound = $rep->response->numFound;
		}
		else {
			$time = -1;
			$numFound = -1;
		}
		$query_id =  ( $query_id == null ) ? "" : $query_id;
		
		$debug = $this->getConfigNodeValueBoolean('//config/debug');
		if( $debug )
			$query_id .= "{" .
				number_format(strlen( $response->getRawResponse() ), 0, ',', ' ')  .
				 "}";
		$this->logRequest(
				SearchMdl::buildSolrRequestFromUserRequest($userRequest,null,$solr),
				$post['action'],$post['sub_action'],$post['mode'],
				$query_id,$numFound,$time );
	}
	
	/**
	 * Renvoie le qf pour le edismax
	 * @return string
	 */
	function edismaxGetQf() {
		return $this->getConfigNodeValue('//config/search/solr_edismax_qf');
	}
	
	/**
	 * Renvoie le mm pour le edismax
	 * @return string
	 */
	function edismaxGetMm() {
		return $this->getConfigNodeValue('//config/search/solr_edismax_mm');
	}
	
	/**
	 * Renvoie un tableau de stopwords
	 * @return string
	 */
	function loadStopWords() {
		$stopword_file = $this->getConfigNodeValue('//config/search/stopwords');
		if (!empty($stopword_file)) {
			$stopword_file = dirname($this->_configFilePath) . '/' . $stopword_file;
			return file ($stopword_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		}
		return null;
	}
	
	/**
	 * Renvoie l'url racine de l'application
	 * @return string
	 */
	function getWebHost() {
		$url = $this->getConfigNodeValue('//config/web_host');
		if (endsWith($url, '/')) $url = substr($url, 0, -1);
		return $url;
	}

	function extractIE8() {
		// return true; // pour tester sous chrome
 		return ( isIE7($this->getMemIE9UserAgents()) || isIE8() )
 					&&
 				$this->getConfigNodeValueBoolean('//config/extract_ie8', false);
	}
	
	function getMemIE9UserAgents() {
		$nodes = $this->getConfigNodes('//config/men_ie9_user_agent');
		$ret = array();
		foreach ($nodes as $node){
			$ret[] = (string)$node;
		}
		return $ret;
	}

}
?>
