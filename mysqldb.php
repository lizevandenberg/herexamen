<?php  

class MysqlDB
{
private $dsn = "mysql:host=127.0.0.1;dbname=mysite";
private $user = "root";
private $passwd = "root";
protected $pdo = null;


	function __construct() 
	{
		$this->pdo = new PDO($this->dsn, $this->user, $this->passwd);
	}
	function __destruct() 
	{
		$this->pdo = null;
	}
	
}



?>