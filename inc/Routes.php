<?php
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
		$this->addRoute("/home", "acceuil/Home", "index", null, "GET");
	}
	
	/**
	 * Add a route for REST routing
	 * 
	 * @param unknown $url
	 * @param unknown $controller
	 * @param unknown $controllerMethod
	 * @param array $paramPattern
	 * @param string $verb
	 */
	public function addRoute($url, $controller, $controllerMethod, Array $paramPattern = array(), $verb = "")
	{
		$this->routes[$url] = array(
				self::CONTROLLER_ROUTE_INDEX => $controller,
				self::METHOD_ROUTE_INDEX => $controllerMethod,
				self::PARAMS_ROUTE_INDEX => $paramPattern,
				self::VERB_ROUTE_INDEX => $verb
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