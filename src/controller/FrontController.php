<?php
require_once ('/src/controller/IFrontController.php');
class FrontController implements IFrontController {
	const CONTROLLER_EXTENSION = "Controller";
	const DEFAULT_CONTROLLER = "Home";
	const DEFAULT_ACTION = "index";
	const CONTROLLER_PATH = "./";
	const DEFAULT_URL = "home";
	const REST_URL = "QUERY_STRING";
	
	protected $controller = self::DEFAULT_CONTROLLER;
	protected $action = self::DEFAULT_ACTION;
	protected $params = array ();
	protected $basePath = "/";
	
	public function __construct() {
		$this->controller = $this->controller . self::CONTROLLER_EXTENSION;
		$this->parseUri ();
		$this->run ();
	}
	
	protected function parseUri() {
		$route = htmlspecialchars ( $_SERVER [self::REST_URL] );
		$page = '';
		
		$sections = mb_split ( "/", $route );
		
		if (count ( $sections ) >= 2) {
			$page = $sections [1];
		} else if (count ( $sections ) == 1 && mb_strlen ( trim ( $sections [0] ) ) === 0) {
			// home page
			$page = self::DEFAULT_URL;
		}
		
		// mecanisme de routing pour appel de la methode controlleur
		
		if (array_key_exists ( $page, $pages )) {
			$routeInfo = $pages [$page];
			$controllerPath = array_keys ( $routeInfo );
			$controllerPath = $controllerPath [0];
			
			$controllerName = basename ( $controllerPath ) . CONTROLLER_EXTENSION;
			
			$method = $routeInfo [$controllerPath];
			$controller = __DIR__ . CONTROLLER_PATH . $controllerPath . CONTROLLER_EXTENSION . PHP_EXTENSION;
			
			if (is_file ( $controller )) {
				require_once ($controller);
				call_user_func_array ( array (
						new $controllerName (),
						$method 
				), array () );
			}
			// echo "controller : $controller, method : $method";
			// include_once("src/view/$page.tpl");
		} else {
			include_once ("layout/404.php");
		}
	}
	
	public function setController($controller) {
		$controller = ucfirst ( strtolower ( $controller ) ) . "Controller";
		if (! class_exists ( $controller )) {
			throw new InvalidArgumentException ( "The action controller '$controller' has not been defined." );
		}
		$this->controller = $controller;
		return $this;
	}
	
	public function setAction($action) {
		$reflector = new ReflectionClass ( $this->controller );
		if (! $reflector->hasMethod ( $action )) {
			throw new InvalidArgumentException ( "The controller action '$action' has been not defined." );
		}
		$this->action = $action;
		return $this;
	}
	
	public function setParams(array $params) {
		$this->params = $params;
		return $this;
	}
	
	public function run() {
		call_user_func_array ( array (
				new $this->controller (),
				$this->action 
		), $this->params );
	}
}

?>