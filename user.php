<?php  

class User extends MysqlDB
{
	protected $userid = null;
	protected $username = null;
    
	public function __construct($username){
		parent::__construct();
		$this->setusername($username);
		$this->setuserid($username);
	} 
   	public function setusername($username){
		$this->username = $username;
		
		return 0;
	}
	
	public function wakeupDBConnection(){
		parent::__construct();
		return 0;
	} 

	public function breakDBConnection(){
		parent::__destruct();
		return 0;
	} 
	
	protected function setuserid($username){
		
		$LookupUserId = $this->pdo->prepare("SELECT userid AS userid FROM userlookup WHERE username = ?");
        $LookupUserId->bindParam(1, $username);
        $LookupUserId->execute();
        $result = $LookupUserId->fetch(PDO::FETCH_ASSOC);
		$result = $result['userid'];
		if(is_numeric($result)){
			$userid = $result;
		}
		else{
			error_log("fatal error. Non numeric userid or userid is null",0);
		}
		
		$this->userid = $userid;
		
		return 0;
	}
	
	public function getusername()
	{
		return $this->username;
	}
	
	public function getuserid($param=null)
	{	
	$this->wakeupDBConnection();
		if(!is_null($param))
	    {
			
		$lookup = $param;		
		$LookupUserId = $this->pdo->prepare('SELECT userid AS userid FROM userlookup WHERE CONCAT(firstname," ",lastname) = ?');
        $LookupUserId->bindParam(1, $lookup);
        $LookupUserId->execute();
        $result = $LookupUserId->fetch(PDO::FETCH_ASSOC);
		$result = $result['userid'];
		if(is_numeric($result)){
			$userid = $result;
		}
		else{
			error_log("fatal error. Non numeric userid or userid is null",0);
		}
		return $this->userid;
		
	    }
		else{
			return $this->userid;
		}
		
		
	}
	
	public function lookupUser($initials){
		$LookupUserId = $this->pdo->prepare("SELECT username, firstname, lastname FROM userlookup WHERE LOWER(username) like CONCAT('%', LOWER(?), '%')");
        $LookupUserId->bindParam(1, $initials);
        $LookupUserId->execute();
        $result = $LookupUserId->fetchAll(PDO::FETCH_ASSOC);
		$results = array();
		
		foreach($result as $row){
			array_push ($results,$row['firstname']." ".$row['lastname'].' ('.$row['username'].')');
			
		}		
		
		return json_encode($result);
	}
}




?>