<?php
	require_once('layout/header.html');
?>
<div id="templatemo_wrapper">
    <div id="templatemo_content_top"></div>
    <div id="templatemo_content">
    	<div id="templatemo_main_content">
			<?php
				//faire une classe ManageLayout qui fait ceci
				/**
				 * recuperation des pages en bdd (mock)
				 * table menu : 
				 *	colonne 1 : id de l'onglet
				 *	colonne 2 : page associée
				 */
				
				$pages = array("1" => "home", "2" => "contact");
				$route = htmlspecialchars($_SERVER['QUERY_STRING']);				
				$section = '';
				
				$sections = mb_split ("/", $route);
				
				if(count($sections) >= 2)
				{
					$section = $sections[1];
				}
				else if(count($sections) == 1 && mb_strlen(trim($sections[0])) === 0)
				{
					//home page
					$section = '1';
				}
				
				//mecanisme de routing pour appel de la methode controlleur
				
				if(array_key_exists($section, $pages))
				{
					$requestedPage = $pages[$section];					
					include_once("src/content/$requestedPage.php");
				}
				else
				{
					include_once("layout/404.php");
				}
			?>
		</div>
        
        <?php
			require_once('layout/sidebar.php');
		?>
        
        <div class="cleaner"></div>
    </div>
	<?php
		require_once('layout/footer.html');
	?>     
</div> <!-- end of wrapper -->

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js'></script>
<script type='text/javascript' src='js/logging.js'></script>
</body>
</html>

