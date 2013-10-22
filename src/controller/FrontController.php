<?php
require_once ('/inc/Routes.php');
/**
 * Dispatch request for call controller method
 * 
 * @author Morgan
 *
 */
class FrontController {
	const CONTROLLER_EXTENSION = "Controller";	
	const CONTROLLER_PATH = DIRECTORY_SEPARATOR;
	const PHP_EXTENSION = ".php";
	const DEFAULT_URL = "/home";
	const REST_URL = "QUERY_STRING";
	
	protected $controller;
	protected $action;
	protected $params = array ();
	protected $basePath = "/";
	
	public function __construct() {
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
			$this->setHeader(404);
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
		$controllerPath = __DIR__ . self::CONTROLLER_PATH . $controller . self::CONTROLLER_EXTENSION . self::PHP_EXTENSION;
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
	
	/**
	 * get status from code
	 * 
	 * @param unknown $code
	 * @return string
	 */
	private function getStatusMessage($code){
		$status = array(
				100 => 'Continue',
				101 => 'Switching Protocols',
				200 => 'OK',
				201 => 'Created',
				202 => 'Accepted',
				203 => 'Non-Authoritative Information',
				204 => 'No Content',
				205 => 'Reset Content',
				206 => 'Partial Content',
				300 => 'Multiple Choices',
				301 => 'Moved Permanently',
				302 => 'Found',
				303 => 'See Other',
				304 => 'Not Modified',
				305 => 'Use Proxy',
				306 => '(Unused)',
				307 => 'Temporary Redirect',
				400 => 'Bad Request',
				401 => 'Unauthorized',
				402 => 'Payment Required',
				403 => 'Forbidden',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				406 => 'Not Acceptable',
				407 => 'Proxy Authentication Required',
				408 => 'Request Timeout',
				409 => 'Conflict',
				410 => 'Gone',
				411 => 'Length Required',
				412 => 'Precondition Failed',
				413 => 'Request Entity Too Large',
				414 => 'Request-URI Too Long',
				415 => 'Unsupported Media Type',
				416 => 'Requested Range Not Satisfiable',
				417 => 'Expectation Failed',
				500 => 'Internal Server Error',
				501 => 'Not Implemented',
				502 => 'Bad Gateway',
				503 => 'Service Unavailable',
				504 => 'Gateway Timeout',
				505 => 'HTTP Version Not Supported');
		return ($status[$code])?$status[$code]:$status[500];
	}
	
	/**
	 * set http header
	 * 
	 * @param unknown $code
	 * @param string $contentType
	 */
	private function setHeader($code, $contentType = null){
		header("HTTP/1.1 ".$code." ".$this->getStatusMessage($code));
		
		if(!StringUtils::isBlank($contentType))
		{
			header("Content-Type:".$this->_content_type);
		}
	}
}

?>