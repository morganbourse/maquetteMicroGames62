<?php
require_once ('/src/utils/StringUtils.php');
require_once ('/src/utils/mail/MailUtils.php');
final class ContactValidator
{
	/**
	 * constructor
	 */
	private function ContactValidator()
	{
		
	}
	
	/**
	 * validateContactForm
	 * 
	 * @param String $author
	 * @param String $email
	 * @param String $phone
	 * @param String $subject
	 * @param String $message
	 */
	public static function validateContactForm($author, $email, $phone, $subject, $message)
	{
		$fieldErrors = array();
		
		if(StringUtils::isBlank($author))
		{
			$fieldErrors['author'] = 'Veuillez renseigner le nom';			
		}
				
		if(!MailUtils::isValidMail($email))
		{
			$fieldErrors['email'] = 'Veuillez renseigner un email valide (ex : xxxxxx@yyyy.zzz)';			
		}
				
		if(!self::isValidPhoneNumber($phone))
		{
			$fieldErrors['phone'] = 'Veuillez renseigner un num&eacute;ro de t&eacute;l&eacute;phone valide (ex : 00 00 00 00 00)';
		}
		
		if(StringUtils::isBlank($subject))
		{
			$fieldErrors['subject'] = 'Veuillez renseigner le sujet du message';			
		}
		
		if(StringUtils::isBlank($message))
		{
			$fieldErrors['message'] = 'Veuillez renseigner le corp du message';			
		}
		
		return $fieldErrors;
	}
		
	/**
	 * validate phone number
	 * 
	 * @param String $phoneNumber
	 * @return boolean
	 */
	public static function isValidPhoneNumber($phoneNumber)
	{
		return (!StringUtils::isBlank($phoneNumber) && preg_match('#^0[0-9](\s*[ ./-]?\s*[0-9]{2}){4}$#', $phoneNumber));
	}
}
?>