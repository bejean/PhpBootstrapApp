<?php
/**
 * Definition de la classe User
 */

/**
 * Classe POJO represntant l'utilisaeur.
 * 
 * @author Taligentia
 *
*/
class User {
	
	/**
	 * @var string identifiant.
	 */
	var $_id;
	/**
	 * @var string	Nom
	 */
	var $_name;
	/**
	 * @var string Prénom
	 */
	var $_firstname;
	/**
	 * @var string E-mail
	 */
	var $_email;
	
	/**
	 * Constructeur
	 * @param string $id
	 * @param string $name
	 * @param string $firstname
	 * @param string $email
	 */
	function __construct($id, $name, $firstname, $email) {
		$this->_id = $id;
		$this->_name = $name;
		$this->_firstname = $firstname;
		$this->_email = $email;
    }
    
    /**
     * Getter
     * @return string L'indentifiant
     */
    function getId() {
    	return $this->_id;
    }
    
    /**
     * Getter
     * @return string Le nom
     */
    function getName() {
    	return $this->_name;
    } 
    
    /**
     * Getter
     * @return string Le prénom
     */
    function getFirstName() {
    	return $this->_firstname;
    } 
    
    /**
     * Getter
     * @return string Le mail
     */
    function getEmail() {
    	return $this->_email;
    }   
    
    /**
     * REnvoie le statut de l'utilsiateur
     * @return booleen Vrai si l'utilsiateur est connecté.
     */
    function isLogged() {
    	return (!empty($this->_id));
    }
}
?>
