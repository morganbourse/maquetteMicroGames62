<?php
require_once ('/src/utils/CollectionUtils.php');
require_once ('/src/utils/StringUtils.php');
class Routes
{
	const CONTROLLER_ROUTE_INDEX = "controller";
	const METHOD_ROUTE_INDEX = "method";
	const VERB_ROUTE_INDEX = "verb";
	const PARAMS_ROUTE_INDEX = "params";
	
	private static $instance = null;
		
	public $routes = array();
	
	private function __construct(){
		//add default routes
		$this->addRoute("/home", "acceuil/Home", "index", "GET");
		$this->addRoute("/contact", "contact/Contact", "index", "GET");
		
		/**
		 * exemple de routes avec des paramètres
		 */
		$this->addRoute("/home/([0-9]+)/test/([0-9]+)", "acceuil/Home", "index", "GET", array("idToto", "idTiti"));
	}
	
	/**
	 * Add a route for REST routing
	 * 
	 * @param unknown $url
	 * @param unknown $controller
	 * @param unknown $controllerMethod
	 * @param string $verb
	 */
	public function addRoute($url, $controller, $controllerMethod, $verb = "GET", Array $params = null)
	{
		$this->routes[$url] = array(
				self::CONTROLLER_ROUTE_INDEX => $controller,
				self::METHOD_ROUTE_INDEX => $controllerMethod,
				self::VERB_ROUTE_INDEX => $verb,
				self::PARAMS_ROUTE_INDEX => $params
		);
	}
	
	/**
	 * Match an url with the routes table
	 * and return an array with elements
	 * 
	 * @param string $url
	 * @return Array or null if route not matched
	 */
	public function match($url)
	{
		$allRouteUrl = array_keys($this->routes);
		if(CollectionUtils::isNotEmpty($allRouteUrl) && !StringUtils::isBlank($url))
		{
			foreach ($this->routes as $route => $config)
			{
				if(preg_match("#^" . $route . "$#", $url, $params) && $config[self::VERB_ROUTE_INDEX] == $_SERVER['REQUEST_METHOD'])
				{
					if($_SERVER['REQUEST_METHOD'] === "GET")
					{
						$configParamNames = $config[self::PARAMS_ROUTE_INDEX];
						//build associative params array
						if(CollectionUtils::isNotEmpty($configParamNames))
						{
							$paramsFromUrl = array_slice($params, 1);
							$params = array();
							foreach ($configParamNames as $index => $paramName)
							{
								$params[$paramName] = $paramsFromUrl[$index];
							}
							
							$config[self::PARAMS_ROUTE_INDEX] = $params;
						}
					}
					else if($_SERVER['REQUEST_METHOD'] === "POST")
					{
						$config[self::PARAMS_ROUTE_INDEX] = $_POST;
					}
					
					//xss and sql injection protection
					if(CollectionUtils::isNotEmpty($config[self::PARAMS_ROUTE_INDEX]))
					{
						$config[self::PARAMS_ROUTE_INDEX] = $this->cleanInputs($config[self::PARAMS_ROUTE_INDEX]);
					}
					
					return $config;
				}
			}
		}
		
		return null;
	}
	
	/**
	 * Clean input data
	 * 
	 * @param unknown $data
	 * @return multitype:NULL 
	 */
	private function cleanInputs($data){
		$clean_input = array();
		if(is_array($data)){
			foreach($data as $key => $value){
				$clean_input[$key] = $this->cleanInputs($value);
			}
		}else{
			if(get_magic_quotes_gpc()){
				$data = trim(stripslashes($data));
			}
			$data = strip_tags($data);
			$clean_input = trim($data);
		}
		return $clean_input;
	}

	/**
	 * Récupère l'instance de la classe
	 *
	 * @return Routes
	 */
	public static function getInstance()
	{
		if(is_null(self::$instance))
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
}
?>