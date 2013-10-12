<div id="templatemo_menu">
	<ul>
		<?php
			/*
			 * construire le menu avec les enregistrement de la table menu
			 * ex : echo "<li><a href='index.php?section=" . $ligne["tabId"] . "' class='$current'>$ligne["tabName"]</a></li>"
			 */
			
		?>
		<li><a href="?/1" class="current">Acceuil</a></li>
		<li><a href="?/info">Informatique</a></li>
		<li><a href="?/console">Console</a></li>
		<li><a href="?/telephonie">T&eacute;l&eacute;phone</a></li>
		<li><a href="?/deblocage">D&eacute;blocage</a></li>
		<li class="last"><a href="?/2">Contact</a></li>
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