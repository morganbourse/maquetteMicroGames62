<?php
//require_once (ROOT_DIR . '/src/model/utils/SafePDO.php');
require_once (ROOT_DIR . "/src/utils/IniManager.php");
require_once (ROOT_DIR . "/src/utils/CollectionUtils.php");
require_once (ROOT_DIR . "/src/utils/StringUtils.php");
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
			$settings = IniManager::getInstance(ROOT_DIR . "/config/config.ini");
			$host = trim($settings->database['host']);
			$port = trim($settings->database['port']);
			$dbname = trim($settings->database['schema']);
			$login = trim($settings->database['login']);
			$pwd = trim($settings->database['pwd']);			
			$charset = StringUtils::ifBlank(trim($settings->database['charset']), 'utf8');

			$this->database = mysql_connect($host . ":" . $port, $login, $pwd);
			if(FALSE === $this->database)
			{
				throw new Exception("Impossible de se connecter à la systeme de gestion de base de données...");
			}
			
			$isSelectedDb = mysql_select_db($dbname, $this->database);
			if(FALSE === $isSelectedDb)
			{
				throw new Exception("Impossible d'acceder à la base de données...");
			}
			
			mysql_set_charset($charset, $this->database);
		} catch (Exception $e) {
			echo $e->getMessage();
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
		$query = "SELECT * FROM :table WHERE id = :id;";
		$queryParams = array("table" => $this->tableName, "id" => $id);
			
		return $this->fetchObject($query, $returnObject, $queryParams);
	}
	
	/**
	 * function findAll
	 * @param String $id
	 * @param T $returnObject
	 * @return array<T>
	 */
	public function findAll($returnObject)
	{
		return $this->fetchObjectList("SELECT * FROM :table;", $returnObject, array("table" => $this->tableName));
	}

	/**
	 * destructeur
	 */
	public function __destruct()
	{
		mysql_close($this->database);
	}
	
	/**
	 * fetch result in list of objects
	 * 
	 * @param unknown $sql
	 * @param unknown $returnObject
	 * @param array $params
	 * @return multitype:unknown 
	 */
	public function fetchObjectList($sql, $returnObject, Array $params = array())
	{
		$result = $this->executeQuery($sql, $params);
		$objectList = array();
		if(CollectionUtils::isNotEmpty($result))
		{
			$refletedObject = new ReflectionObject($returnObject);
			while($row = mysql_fetch_object($result, $refletedObject->getName()))
			{
				$objectList[] = $row;
			}			
		}
		
		mysql_free_result($result);
		return $objectList;
	}
	
	/**
	 * Fetch Unique object
	 * 
	 * @param unknown $sql
	 * @param unknown $returnObject
	 * @param array $params
	 */
	public function fetchObject($sql, $returnObject, Array $params = array())
	{		
		$result = $this->executeQuery($sql, $params);
		$returnObject = null;
		if(CollectionUtils::isNotEmpty($result))
		{
			$refletedObject = new ReflectionObject($returnObject);
			$returnObject = mysql_fetch_object($result, $refletedObject->getName());			
		}
		
		mysql_free_result($result);
		
		return $returnObject;
	}
	
	/**
	 * Get sanitized sql
	 * 
	 * @param unknown $sql
	 * @param array $params
	 * @return unknown
	 */
	protected function getSanitizedSql($sql, Array $params = array())	
	{
		if(CollectionUtils::isNotEmpty($params))
		{
			foreach ($params as $key => $value)
			{
				$protectedValue = $value;
				if(get_magic_quotes_gpc())
				{
					$protectedValue = stripslashes($protectedValue);
				}
		
				$protectedValue = mysql_real_escape_string($protectedValue);
		
				$sql = str_replace(":" . $key, $protectedValue, $sql);
			}
		}
		
		return $sql;
	}
	
	/**
	 * execute query string
	 * 
	 * This method sanitize automatically sql parameters
	 * 
	 * @param unknown $sql
	 * @param array $params
	 */
	public function executeQuery($sql, Array $params = array())
	{
		$query = $this->getSanitizedSql($sql, $params);
		return @mysql_query($query, $this->database);
	}
}
?>