<?php
/**
 * Fonctions utilitaires génériques
 *
 * @author Taligentia
 * @version 1.0
 * @package lib
 */

/**
 * Lit une valeur dans la requête par ordre de priorité $_GET puis $_POST
 */
function getRequestParam($paramName, $default = '') {
	if (isset($_GET[$paramName])) return $_GET[$paramName];
	if (isset($_POST[$paramName])) return $_POST[$paramName];
	if (!empty($default)) return $default;
	return '';
}

/**
 * Lit une valeur dans un tableau puis la requête par ordre de priorité $_GET puis $_POST
 */
function getRequestParam2($paramName, $_P, $default = '') {
	if (isset($_P[$paramName])) return $_P[$paramName];
	if (isset($_GET[$paramName])) return $_GET[$paramName];
	if (isset($_POST[$paramName])) return $_POST[$paramName];
	if (!empty($default)) return $default;
	return '';
}

/**
 * Détermine si une chaine commence par une sous-chaine
 */
function startsWith($haystack,$needle,$case=true) {
	if ($case) return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);
	return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
}

/**
 * Détermine si une chaine se termine par une sous-chaine
 */
function endsWith($haystack,$needle,$case=true) {
	$expectedPosition = strlen($haystack) - strlen($needle);
	if($case) return strrpos($haystack, $needle, 0) === $expectedPosition;
	return strripos($haystack, $needle, 0) === $expectedPosition;
}

/**
 * Suppression des accents dans une chaine
 */
function accentsReplace($string) {
	return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string);
}


/**
 * Récupération de tout ce qui est placé devant le dernier "/" dans une chaine
 */
function last_index_of($sub_str,$instr) {
	if(strstr($instr,$sub_str)!="") {
		return(strlen($instr)-strpos(strrev($instr),$sub_str));
	}
	return(-1);
}

function getRootPath($path) {
	$pos = last_index_of('/',$path);
	return substr($path, 0, $pos);
}

/**
 * Formatage d'une chaine représentant un entier. Ajout d'un espace séparateur des milliers.
 */
function formatInteger( $nb ) {
	return number_format($nb,0,',',' ');
}

function str_nomalize_utf8($str) {
	$ret = mb_strtolower($str,'UTF-8');
	return mb_convert_case($ret, MB_CASE_TITLE, "UTF-8");
}

function str_utf8To8859_1($str) {
	return mb_convert_encoding($str, "ISO-8859-1", "UTF-8" );
/* 	return iconv("UTF-8", "ISO-8859-1", $str); */
}

function isIE () {
	$browser = getBrowser();
	$ret = ($browser['name']=='Internet Explorer');
	return $ret;
}

function isIE7 ($men_ie9_user_agent='') {
	
//	if (!empty($men_ie9_user_agent) && in_array($_SERVER['HTTP_USER_AGENT'], $men_ie9_user_agent)) {
//		// Si un de ces user-agent est détecté alors on ne retourne pas un faux positif
//		return false;		
//	}

	$browser = getBrowser();
	$ret = ($browser['name']=='Internet Explorer' && startsWith($browser['version'],'7.'));
	
	if ($ret) {
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/windows\\s+nt\\s+6[.]1/i', $u_agent)) {
			return false;
		}
	}
	
	return $ret;
}

function isIE8 () {
	$browser = getBrowser();
	return ($browser['name']=='Internet Explorer' && startsWith($browser['version'],'8.'));
}

function getBrowser()
{
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	//file_put_contents('/tmp/log.txt', "$u_agent\n", FILE_APPEND);
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";

	//First get the platform?
	if (preg_match('/linux/i', $u_agent)) {
		$platform = 'linux';
	}
	elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		$platform = 'mac';
	}
	elseif (preg_match('/windows|win32/i', $u_agent)) {
		$platform = 'windows';
	}

	// Next get the name of the useragent yes seperately and for good reason
	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
	{
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	}
	elseif(preg_match('/Firefox/i',$u_agent))
	{
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	}
	elseif(preg_match('/Chrome/i',$u_agent))
	{
		$bname = 'Google Chrome';
		$ub = "Chrome";
	}
	elseif(preg_match('/Safari/i',$u_agent))
	{
		$bname = 'Apple Safari';
		$ub = "Safari";
	}
	elseif(preg_match('/Opera/i',$u_agent))
	{
		$bname = 'Opera';
		$ub = "Opera";
	}
	elseif(preg_match('/Netscape/i',$u_agent))
	{
		$bname = 'Netscape';
		$ub = "Netscape";
	}

	// finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
	')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
		// we have no matching number just continue
	}

	// see how many we have
	$i = count($matches['browser']);
	if ($i != 1) {
		//we will have two since we are not using 'other' argument yet
		//see if version is before or after the name
		if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			$version= $matches['version'][0];
		}
		else {
			$version= $matches['version'][1];
		}
	}
	else {
		$version= $matches['version'][0];
	}

	// check if we have a number
	if ($version==null || $version=="") {$version="?";}

	$ret = array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
	);
		
	return $ret;
}

function fjsp($value) {
	return htmlspecialchars(addslashes($value), ENT_QUOTES, "UTF-8", false);
}

function fi($value) {
	return htmlspecialchars($value, ENT_QUOTES, "UTF-8", false);
}

?>