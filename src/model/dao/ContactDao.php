<?php
	require_once('GenericDao.php');
	/**
	 * Interact with contact database table
	 * 
	 * @author Morgan
	 */
	class ContactDao extends GenericDao
	{
		const TABLE_NAME = "contact";
		
		/**
		 * Constructeur
		 */
		public function ContactDao()
		{
			parent::GenericDao(self::TABLE_NAME);			
		}
	}
?>