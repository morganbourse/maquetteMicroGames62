<?php
require_once ('/inc/rain.tpl.class.php');
require_once ('/src/utils/CollectionUtils.php');
require_once ('/src/utils/StringUtils.php');
require_once ('/src/controller/ControllerException.php');

/**
 * Base Controller
 * @author Morgan
 *
 */
abstract class Controller
{
	protected $tpl;

	/**
	 * Constructor
	 */
	public function Controller()
	{
		RainTPL::$tpl_dir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "view" . DIRECTORY_SEPARATOR;
		RainTPL::$cache_dir = DIRECTORY_SEPARATOR . "tmp";
		RainTPL::$path_replace = false;
		RainTPL::$tpl_ext = "tpl";

		$this->tpl = new RainTPL();
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
			throw new ControllerException("The template name to load cannot be an empty string", "EMPTY_TEMPLATE_NAME");
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
			throw new ControllerException("The template name to load cannot be an empty string", "EMPTY_TEMPLATE_NAME");
		}

		$this->tpl->draw($templateName, true); // get the template as String
	}
	
	/**
	 * Default controller function
	 */
	abstract function index();
}
?>