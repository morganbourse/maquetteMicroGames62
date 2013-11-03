<?php
require_once ('/src/model/utils/SafePDO.php');
require_once ("/src/utils/IniManager.php");
class GenericDao
{
	protected $database;
	protected $tableName;

	/**
	 * Constructeur
	 */
	public function GenericDao($tableName)
	{
		try {
			$settings = IniManager::getInstance("/config/config.ini");
			$host = trim($settings->database['host']);
			$port = trim($settings->database['port']);
			$dbname = trim($settings->database['schema']);
			$login = trim($settings->database['login']);
			$pwd = trim($settings->database['pwd']);
			$persistantConnection = $settings->database['persistantConnection'];
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

			if($persistantConnection)
			{
				$options[PDO::ATTR_PERSISTENT] = true;
			}

			$this->database = new SafePDO("mysql:host=$host;dbname=$dbname;port=$port", $login, $pwd, $options);
		} catch (Exception $e) {
			echo "Impossible de se connecter � la base de donn�es...";
			$this->database = null;
			die();
		}

		$this->tableName = $tableName;
	}

	/**
	 * function which return unique id
	 */
	public static final function getUniqueId()
	{
		return uniqid();
	}

	/**
	 * function findById
	 * @param String $id
	 * @param T $returnObject
	 * @return array<T>
	 */
	public function findById($id, $returnObject)
	{
		$query = $this->database->prepare("SELECT * FROM " . $this->tableName . " WHERE id = :id;");
		$query->execute(array( 'id' => $id ));
		$refletedObject = new ReflectionObject($returnObject);
		$query->setFetchMode(PDO::FETCH_CLASS, $refletedObject->getName());
		return $query->fetch();
	}
	
	/**
	 * function findAll
	 * @param String $id
	 * @param T $returnObject
	 * @return array<T>
	 */
	public function findAll($returnObject)
	{
		$query = $this->database->query("SELECT * FROM " . $this->tableName . ";");		
		$refletedObject = new ReflectionObject($returnObject);
		$query->setFetchMode(PDO::FETCH_CLASS, $refletedObject->getName());
		return $query->fetchAll();
	}

	/**
	 * destructeur
	 */
	public function __destruct()
	{

	}
}
?>