<?php
	require_once (ROOT_DIR . '/src/model/services/impl/MenuService.php');	
	require_once (ROOT_DIR . '/src/controller/Controller.php');
						
	/**
	 * Menu controller
	 * 
	 * @author Morgan
	 *
	 */
	class MenuController extends Controller
	{
		/**
		 * @see src/controller/Controller::index()
		 */
		public function index()
		{
			
		}
		
		/**
		 * get html menu
		 * @param array $tabs
		 * @return string
		 */
		public function getMenu(Array $tabs = null)
		{
			if(CollectionUtils::isEmpty($tabs))
			{
				$menuService = new MenuService();			
				$tabs = $menuService->getMenuTabs();
			}
			
			$menuContentHtml = "";
			
			if(CollectionUtils::isNotEmpty($tabs))
			{				
				foreach ($tabs as $tab)
				{
					$tabId = $tab->getId();
					$tabLabel = $tab->getLabel();	
					$pageName = $tab->getPageName();				
					$className = "";
										
					if($tabId == 1)
					{
						$className = 'class="current"';
					}
					
					$menuContentHtml .= '<li><a href="?/' . $pageName . '" ' . $className . '>' . $tabLabel . '</a></li>';
				}
			}
			
			return $menuContentHtml;
		}
	}
?>