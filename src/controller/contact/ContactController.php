<?php
require_once ('/src/controller/Controller.php');
require_once ('/src/utils/IniManager.php'); 
require_once ('/src/utils/mail/MailUtils.php');
require_once ('src/controller/contact/ContactValidator.php');

/**
 * ContactController
 * @author Morgan
 *
 */
class ContactController extends Controller
{
	const TPL = "contact";
	const TPL_MAIL = "contactMail";
	const ERROR_MAIL_SEND_MSG = "Un probl&eacute;me est survenu lors de l'envoi de mail.<br />Veuillez r&eacute;essayer plus tard, ou utiliser l'adresse mail de contact.";
	
	/**
	 * @see src/controller/Controller::index()
	 */
	public function index()
	{
		$settings = IniManager::getInstance("/config/config.ini");
		$mapsKey = $settings->maps['key'];
		$this->draw(self::TPL, array(
			"address" => "adresse inconnue",
			"codePostal" => "00000",
			"ville" => "ville inconnue",
			"tel" => "03.21.00.00.00",
			"mapsKey" => $mapsKey
		));
	}
	
	/**
	 * sendMail action
	 * 
	 * Send an email from contact page
	 * 
	 * @return json
	 */
	public function sendMail($author, $email, $phone, $subject, $message) {
		$error = null;
		$sendSuccessful = false;
		
		$fieldErrors = ContactValidator::validateContactForm($author, $email, $phone, $subject, $message);
		$isValidate = CollectionUtils::isEmpty($fieldErrors);
		
		if(!$isValidate)
		{
			$json = array("success" => $sendSuccessful, "error" => $error, "fieldErrors" => $fieldErrors);
			$this->renderJson($json);
			return;
		}
		
		try 
		{
			$messageText = $this->getTemplateAsString(self::TPL_MAIL, array(
				"name" => $author,
				"mail" => $email,
				"phone" => StringUtils::formatFrenchPhoneNumber($phone),
				"subject" => $subject,
				"message" => $message
			));		
			
			$settings = IniManager::getInstance("/config/config.ini");
			$mailReceiver = $settings->mail['receiver'];
			$receiverSubject = $settings->mail['subject'];
		
			$mail = new MailUtils($email, $mailReceiver);
			
			if($mail->send($receiverSubject, $messageText))
			{
				$sendSuccessful = true;
			}
		}
		catch(Exception $ex)
		{
			$error = self::ERROR_MAIL_SEND_MSG;			
		}
		
		$json = array("success" => $sendSuccessful, "error" => $error, "fieldErrors" => null);
		$this->renderJson($json);
	}
}
?>