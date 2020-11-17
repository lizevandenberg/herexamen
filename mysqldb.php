<?php  

class MysqlDB
{
	private $dsn = "mysql:host=localhost;dbname=lizeva1q_mysite";
	private $user = "lizeva1q_root";
	private $passwd = "Utopie6december";
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