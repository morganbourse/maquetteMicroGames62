<?php
	require_once ('/src/model/services/impl/MenuService.php');
	require_once ('/src/utils/CollectionUtils.php');
	require_once ('/src/utils/StringUtils.php');
						
	class MenuController
	{
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
					$className = "";
					
					if(!StringUtils::isEmpty($currentId))
					{
						$className = 'class="current"';
					}
					else if(StringUtils::isEmpty($currentId) && $tabId == 1)
					{
						$className = 'class="current"';
					}
					
					$menuContentHtml .= '<li><a href="?/' . $tabId . '"' . $className . '>' . $tabLabel . '</a></li>';
				}
			}
			
			return $menuContentHtml;
		}
	}
?>