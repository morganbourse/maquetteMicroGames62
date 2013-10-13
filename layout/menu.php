<div id="templatemo_menu">
	<ul>
		<?php
			/*
			 * construire le menu avec les enregistrement de la table menu
			 * ex : echo "<li><a href='index.php?section=" . $ligne["tabId"] . "' class='$current'>$ligne["tabName"]</a></li>"
			 */
			require_once ('/src/controller/menu/MenuController.php');
			$ctrl = new MenuController();
			echo $ctrl->getMenu();
		?>
	</ul>
	
	<!--
	<div id="search_box">
		<form action="#" method="post">
			<input type="text" value="Search on this website" name="q" size="10" id="searchfield" title="searchfield" onfocus="clearText(this)" onblur="clearText(this)" />
			<input type="submit" name="Search" value="" id="searchbutton" title="Search" />
		</form>
	</div>
	-->
	<div class="cleaner"></div>    	
</div>