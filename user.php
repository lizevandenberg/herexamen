<?php  

class User extends MysqlDB
{
	protected $userid = null;
	protected $username = null;
    
	public function __construct($username){
		parent::__construct();
		$this->setusername($username);
		$this->setuserid($userid);
		$this->setcsrf();
	} 
   	public function setusername($username){
		$this->username = $username;
		
		return 0;
	} 
	
	protected function setuserid($userid){
		
		$LookupUserId = $this->pdo->prepare("SELECT userid AS userid FROM userlookup WHERE username = ?");
        $LookupUserId->bindParam(1, $this->username);
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
	
	public function getuserid($username=null)
	{	if(!is_null($username))
	    {
			
		$lookup = $username;		
		$LookupUserId = $this->pdo->prepare("SELECT userid AS userid FROM userlookup WHERE username = ?");
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
}



?>