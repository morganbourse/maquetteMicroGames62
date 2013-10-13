<?php
	require_once('GenericDao.php');
	class MenuDao extends GenericDao
	{
		const TABLE_NAME = "menu";
		/**
		 * Constructeur
		 */
		public function MenuDao()
		{
			parent::GenericDao(self::TABLE_NAME);			
		}
	}
?>