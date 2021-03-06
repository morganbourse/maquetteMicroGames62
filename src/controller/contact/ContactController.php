<?php
require_once (ROOT_DIR . '/src/controller/Controller.php');
require_once (ROOT_DIR . '/src/utils/IniManager.php'); 
require_once (ROOT_DIR . '/src/utils/mail/MailUtils.php');
require_once (ROOT_DIR . '/src/controller/contact/ContactValidator.php');
require_once (ROOT_DIR . '/src/model/services/impl/ContactService.php');

/**
 * ContactController
 * @author Morgan
 *
 */
class ContactController extends Controller
{
	const TPL = "contact";
	const TPL_MAIL = "contactMail";
	const ERROR_MAIL_SEND_MSG = "Un probl&egrave;me est survenu lors de l'envoi de mail.<br /><br />Veuillez r&eacute;essayer plus tard, ou utiliser l'adresse mail de contact.";
	
	/**
	 * @see src/controller/Controller::index()
	 */
	public function index()
	{
		$settings = IniManager::getInstance(ROOT_DIR . "/config/config.ini");
		$mapsKey = $settings->maps['key'];
		
		$contactService = new ContactService();
		$contactList = $contactService->getAllContact();
		
		$this->draw(self::TPL, array(
			"contactList" => $contactList,
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
			
			$settings = IniManager::getInstance(ROOT_DIR . "/config/config.ini");
			$mailReceiver = $settings->mail['receiver'];
			$receiverSubject = $settings->mail['subject'];
		
			$mail = new MailUtils($email, $mailReceiver);
			
			if($mail->send($receiverSubject, $messageText))
			{
				$sendSuccessful = true;
			}
			else
			{
				$error = self::ERROR_MAIL_SEND_MSG;
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