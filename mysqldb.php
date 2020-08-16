<?php  

class MysqlDB
{
private $dsn = "mysql:host=localhost;dbname=mysite";
private $user = "root";
private $passwd = "root";
public $pdo = null;


	function __construct() 
	{
		$this->pdo = new PDO($this->dsn, $this->user, $this->passwd);
	}
	function __destruct() 
	{
		$this->pdo = null;
	}
	public function getpdo(){
		return $this->pdo;
	}
	
}



?>