<?php
	require_once('layout/header.php');
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
				define('CONTROLLER_EXTENSION', "Controller");
				define('PHP_EXTENSION', ".php");
				define('CONTROLLER_PATH', DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "controller" . DIRECTORY_SEPARATOR);
				define('DEFAULT_PAGE', "home");
				
				$pages = array("home" => array("acceuil/Home" => "index"), "contact" => array("contact/Contact" => "index"));
				$route = htmlspecialchars($_SERVER['QUERY_STRING']);				
				$page = '';

				$sections = mb_split ("/", $route);
				
				if(count($sections) >= 2)
				{
					$page = $sections[1];
				}
				else if(count($sections) == 1 && mb_strlen(trim($sections[0])) === 0)
				{
					//home page
					$page = DEFAULT_PAGE;
				}
				
				//mecanisme de routing pour appel de la methode controlleur
				
				if(array_key_exists($page, $pages))
				{
					$routeInfo = $pages[$page];
					$controllerPath = array_keys($routeInfo);
					$controllerPath = $controllerPath[0];
					
					$controllerName = basename($controllerPath) . CONTROLLER_EXTENSION;
					
					$method = $routeInfo[$controllerPath];
					$controller = __DIR__ . CONTROLLER_PATH . $controllerPath . CONTROLLER_EXTENSION . PHP_EXTENSION;
					
					if(is_file($controller))
					{
						require_once ($controller);
						call_user_func_array(array(new $controllerName, $method), array());
					}
					//echo "controller : $controller, method : $method";
					//include_once("src/view/$page.tpl");
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

