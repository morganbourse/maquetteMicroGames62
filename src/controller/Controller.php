<?php
require_once (ROOT_DIR . '/inc/rain.tpl.class.php');
require_once (ROOT_DIR . '/src/utils/CollectionUtils.php');
require_once (ROOT_DIR . '/src/utils/StringUtils.php');
require_once (ROOT_DIR . '/src/controller/ControllerException.php');
require_once (ROOT_DIR . '/inc/JSON.php');
require_once (ROOT_DIR . '/src/utils/HeaderUtils.php');

/**
 * Base Controller
 * @author Morgan
 *
 */
abstract class Controller
{
	protected $tpl;
	protected $json;

	/**
	 * Constructor
	 */
	public function Controller()
	{
		RainTPL::$tpl_dir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "view" . DIRECTORY_SEPARATOR;
		RainTPL::$cache_dir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR;
		RainTPL::$path_replace = false;
		RainTPL::$tpl_ext = "tpl";

		$this->tpl = new RainTPL();
		$this->json = new Services_JSON();
	}

	/**
	 * draw the template in the response
	 * @param String $templateName
	 * @param array $variables
	 * @throws ControllerException
	 */
	public function draw($templateName, Array $variables = null)
	{
		if(CollectionUtils::isNotEmpty($variables))
		{
			$this->tpl->assign($variables);
		}

		if(StringUtils::isEmpty($templateName))
		{
			throw new ControllerException("The template name to load cannot be an empty string");
		}
				
		$this->tpl->draw($templateName); // draw the template
	}

	/**
	 * get the template as string
	 * @param String $templateName
	 * @param array $variables
	 * @throws ControllerException
	 */
	public function getTemplateAsString($templateName, Array $variables = null)
	{
		if(CollectionUtils::isNotEmpty($variables))
		{
			$this->tpl->assign($variables);
		}

		if(StringUtils::isEmpty($templateName))
		{
			throw new ControllerException("The template name to load cannot be an empty string");
		}

		return $this->tpl->draw($templateName, true); // get the template as String
	}
	
	/**
	 * renderJson
	 * 
	 * @param array $jsonArray
	 */
	public function renderJson(Array $jsonArray, $httpCode = 200)
	{
		HeaderUtils::setHeader($httpCode, "application/json");
		echo $this->json->encode($jsonArray);
	}
	
	/**
	 * Default controller function
	 */
	abstract function index();
}
?>