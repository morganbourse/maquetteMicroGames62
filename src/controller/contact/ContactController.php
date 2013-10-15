<?php
require_once ('/src/controller/Controller.php'); 

/**
 * ContactController
 * @author Morgan
 *
 */
class ContactController extends Controller
{
	/**
	 * @see src/controller/Controller::index()
	 */
	public function index()
	{
		$this->draw("contact", array(
			"address" => "adresse inconnue",
			"codePostal" => "00000",
			"ville" => "ville inconnue",
			"tel" => "03.21.00.00.00"
		));
	}
}
?>