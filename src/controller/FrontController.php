<?php
require_once (ROOT_DIR . '/inc/Routes.php');
require_once (ROOT_DIR . '/src/utils/HeaderUtils.php');

/**
 * Dispatch request for call controller method
 * 
 * @author Morgan
 *
 */
class FrontController {
	const CONTROLLER_EXTENSION = "Controller";
	const PHP_EXTENSION = ".php";
	const DEFAULT_URL = "/home";
	const REST_URL = "QUERY_STRING";
	
	protected $controller;
	protected $controllerPath;
	protected $action;
	protected $params = array ();
	protected $basePath = "/";
	
	public function __construct() {
		$this->controllerPath = DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "controller". DIRECTORY_SEPARATOR;
		$this->parseUri ();
		$this->run ();
	}
	
	/**
	 * parse the uri for determinate route
	 */
	protected function parseUri() {
		$route = htmlspecialchars ( $_SERVER [self::REST_URL] );
		
		if(StringUtils::isBlank($route))
		{
			$route = self::DEFAULT_URL;
		}
		
		$routeInfo = Routes::getInstance()->match($route);
		
		if(CollectionUtils::isEmpty($routeInfo))
		{
			HeaderUtils::setHeader(404);
			return;
		}
		
		$this->setController($routeInfo[Routes::CONTROLLER_ROUTE_INDEX], $route);
		$this->setAction($routeInfo[Routes::METHOD_ROUTE_INDEX]);
		$this->setParams($routeInfo[Routes::PARAMS_ROUTE_INDEX]);
	}
	
	/**
	 * set the controller
	 * 
	 * @param unknown $controller
	 * @param unknown $route
	 * @throws InvalidArgumentException
	 */
	protected function setController($controller, $route) {
		$controllerPath = ROOT_DIR . $this->controllerPath . $controller . self::CONTROLLER_EXTENSION . self::PHP_EXTENSION;
		$controller = ucfirst(basename($controller)) . self::CONTROLLER_EXTENSION;		
		
		if (!is_file ( $controllerPath )) {
			throw new InvalidArgumentException ( "The controller cannot be found for route $route." );
		}
		
		require_once ($controllerPath);
		
		if (! class_exists ( $controller )) {
			throw new InvalidArgumentException ( "The controller cannot be found for route $route." );
		}
		$this->controller = $controller;
	}
	
	/**
	 * set the called method in controller
	 * 
	 * @param unknown $action
	 * @throws InvalidArgumentException
	 */
	protected function setAction($action) {
		$reflector = new ReflectionClass ( $this->controller );
		if (! $reflector->hasMethod ( $action )) {
			throw new InvalidArgumentException ( "The controller action '$action' has been not defined." );
		}
		$this->action = $action;
	}
	
	/**
	 * set array params passed to the controller
	 * 
	 * @param array $params
	 */
	protected function setParams(Array $params = null) {
		if($params == null)
		{
			$params = array();
		}
		
		$this->params = $params;
	}
	
	/**
	 * run controller method
	 */
	protected function run() {
		if(!StringUtils::isBlank($this->controller))
		{
			call_user_func_array ( array (
					new $this->controller(),
					$this->action 
			), $this->params );
		}
	}
}

?>