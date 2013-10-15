<?php
require_once ('/src/controller/Controller.php'); 

/**
 * HomeController
 * @author Morgan
 *
 */
class HomeController extends Controller
{
	/**
	 * display home page
	 */
	public function index()
	{
		$this->draw("home");
	}
}
?>