<?php
require_once('Entity.php');
/**
 * Contact Entity
 * 
 * @author Morgan
 */
class Contact extends Entity
{
	private $rue;
	private $codePostale;
	private $ville;
	private $telephone;
	private $mail;
	private $principal;
	
	/**
	 * constructor
	 */
	public function Contact()
	{
		
	}
	
	/**
	 * get rue
	 */
	public function getRue()
	{
		return $this->rue;
	}
	
	/**
	 * set the rue
	 * @param string $rue
	 */
	public function setRue($rue)
	{
		$this->rue = $rue;
	}
	
	/**
	 * get the codePostale
	 */
	public function getCodePostale()
	{
		return $this->codePostale;
	}
	
	/**
	 * set the code postale
	 * @param String $cp
	 */
	public function setCodePostale($cp)
	{
		$this->codePostale = $cp;
	}
	
	/**
	 * get the city
	 */
	public function getVille()
	{
		return $this->ville;
	}
	
	/**
	 * set the city
	 * 
	 * @param unknown $ville
	 */
	public function setVille($ville)
	{
		$this->ville = $ville;
	}
	
	/**
	 * get the phone number
	 */
	public function getTelephone()
	{
		return $this->telephone;
	}
	
	/**
	 * set the phone number
	 * 
	 * @param unknown $telephone
	 */
	public function setTelephone($telephone)
	{
		$this->telephone = $telephone;
	}
	
	/**
	 * get the email
	 */
	public function getMail()
	{
		return $this->mail;
	}
	
	/**
	 * set the email
	 * 
	 * @param unknown $mail
	 */
	public function setMail($mail)
	{
		$this->mail = $mail;
	}
	
	/**
	 * get principal
	 */
	public function isPrincipal()
	{
		return $this->principal;
	}
	
	/**
	 * Set principal (true) or secondary (false) address
	 * 
	 * @param unknown $principal
	 */
	public function setPrincipal($principal)
	{
		$this->principal = $principal;
	}
}
?>