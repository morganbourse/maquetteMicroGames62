<?php
require_once ('/src/controller/Controller.php'); 

/**
 * PhonesController
 * @author Morgan
 *
 */
class PhonesController extends Controller
{
	const TPL = "phones";
	
	/**
	 * display home page
	 */
	public function index()
	{
		$this->draw(self::TPL);
	}
}
?>