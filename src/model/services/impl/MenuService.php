<?php
require_once ('/src/model/dao/MenuDao.php');
require_once ('/src/model/entity/Menu.php');
require_once ('/src/model/services/IMenuService.php');

/**
 * Menu Service
 * @author Morgan
 *
 */
class MenuService implements IMenuService
{
	private $menuDao;
	public function MenuService()
	{
		$this->menuDao = new MenuDao();
	}
	
	/**
	 * @see src/model/services/IMenuService::getMenuTabs()
	 */
	public function getMenuTabs()
	{
		return $this->menuDao->findAll(new Menu());
	}
	
	/**
	 * @see src/model/services/IMenuService::getMenuTabById()
	 */
	public function getMenuTabById($id)
	{
		return $this->menuDao->findById($id, new Menu());
	}
}
?>