<?php
	interface IMenuService
	{
		/**
		 * get all menu tabs
		 */
		function getMenuTabs();
		
		/**
		 * get a menu tab by id
		 * @param Menu $id
		 */
		function getMenuTabById($id);
	}
?>