<?php
	require_once(ROOT_DIR . '/src/model/dao/GenericDao.php');
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