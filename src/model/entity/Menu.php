<?php
	require_once(ROOT_DIR . '/src/model/entity/Entity.php');
	class Menu extends Entity
	{
		private $label;
		private $pageName;
		
		/**
		 * get the menu label
		 */
		public function getLabel()
		{
			return $this->label;
		}
		
		/**
		 * set the menu label
		 * @param String label
		 */
		public function setLabel($label)
		{
			$this->label = $label;
		}
		
		/**
		 * get the page name content
		 */
		public function getPageName()
		{
			return $this->pageName;
		}
		
		/**
		 * set the page name content
		 * @param String pageName
		 */
		public function setPageName($pageName)
		{
			$this->pageName = $pageName;
		}
	}
?>