<?php
	require_once ('/src/model/services/impl/MenuService.php');	
	require_once ('/src/controller/Controller.php');
						
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
		 * @param String $currentId
		 * @return string
		 */
		public function getMenu(Array $tabs = null, $currentId = null)
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
					
					if(!StringUtils::isEmpty($currentId))
					{
						$className = 'class="current"';
					}
					else if(StringUtils::isEmpty($currentId) && $tabId == 1)
					{
						$className = 'class="current"';
					}
					
					$menuContentHtml .= '<li><a href="?/' . $pageName . '"' . $className . '>' . $tabLabel . '</a></li>';
				}
			}
			
			return $menuContentHtml;
		}
	}
?>