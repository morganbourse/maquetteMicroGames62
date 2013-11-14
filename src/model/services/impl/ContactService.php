<?php
require_once ('/src/model/dao/ContactDao.php');
require_once ('/src/model/entity/Contact.php');
require_once ('/src/model/services/IContactService.php');

/**
 * Contact Service
 * @author Morgan
 *
 */
class ContactService implements IContactService
{
	private $contactDao;
	
	/**
	 * constructor 
	 */
	public function ContactService()
	{
		$this->contactDao = new ContactDao();
	}
	
	/**
	 * @see src/model/services/IContactService::getAllContact()
	 */
	public function getAllContact()
	{
		return $this->contactDao->findAll(new Contact());
	}
	
	/**
	 * @see src/model/services/IContactService::getContactById($id)
	 */
	public function getContactById($id)
	{
		return $this->contactDao->findById($id, new Contact());
	}
}
?>