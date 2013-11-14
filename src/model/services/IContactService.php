<?php
	/**
	 * @author Morgan
	 *
	 */
	interface IContactService
	{
		/**
		 * get all contact
		 */
		function getAllContact();
		
		/**
		 * get a contact by id
		 * @param Menu $id
		 */
		function getContactById($id);
	}
?>