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
				$section = (isset($_GET['section'])) ? htmlspecialchars($_GET['section']) : '1';
								
				if(array_key_exists($section, $pages))
				{
					$requestedPage = $pages[$section];					
					include_once("src/content/$requestedPage.php");
				}
				else
				{
					include_once("src/content/home.php");
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

