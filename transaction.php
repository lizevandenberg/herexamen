<?php  

class Transaction extends MysqlDB
{
	
	
	public function __construct(){
		parent::__construct();
	} 
	
	public function getbalance($userid) {
		parent::__construct();
		$GetBalanceQuery = $this->pdo->prepare("SELECT totalbalance as balance FROM `balances` WHERE userid = ?");
        $GetBalanceQuery->bindParam(1, $userid);
        $GetBalanceQuery->execute();
        $result = $GetBalanceQuery->fetch(PDO::FETCH_ASSOC);
		$result = $result['balance'];
		return $result;
	}
	

	
	public function getTransactionOverview($userid,$isajax=null){
		parent::__construct();
		$qry = "SELECT transactionId, sender, receiver ,senderid, receiverid, CASE WHEN senderid = ? THEN(amount *-1) WHEN receiverid = ? THEN amount END AS amount, comment, transactionoverwiew.timestamp as timestamp FROM `transactionoverwiew` WHERE senderid=? OR receiverid=? ";
		if(!is_null($isajax))
	    {
			$qry = $qry."AND transactionoverwiew.timestamp > DATE_ADD(NOW(), INTERVAL -10 SECOND)";
		}
		//echo($qry);
		$GetTranOverwiew = $this->pdo->prepare($qry);
		$GetTranOverwiew->bindParam(1, $userid);
		$GetTranOverwiew->bindParam(2, $userid);
		$GetTranOverwiew->bindParam(3, $userid);
		$GetTranOverwiew->bindParam(4, $userid);		
        $GetTranOverwiew->execute();
        $result = $GetTranOverwiew->fetchAll(PDO::FETCH_ASSOC);
		$results = array();
		foreach($result as $row){
			if ($userid == $row['receiverid']){
				$dt = strtotime($row['timestamp']);
				
				$listitem = $row['sender']." sent you ".$row['amount']." tokens on ". date("l jS \of F Y H:i:s",$dt);
				//error_log($listitem,0);
				$tuple = array();
				$tuple['transactioninfo'] = $listitem;
				$tuple['transactionId'] = $row['transactionId'];
				array_push($results,json_encode($tuple));
			}
			elseif($userid == $row['senderid']){
				$dt = strtotime($row['timestamp']);
				$listitem ="you received ".$row['amount']." tokens from ".$row['sender']." on ". date("l jS \of F Y H:i:s",$dt);
				
				$tuple = array();
				$tuple['transactioninfo'] = $listitem;
				$tuple['transactionId'] = $row['transactionId'];
				print_r($tuple);
				array_push($results,json_encode($tuple));

			}
		}
		//echo $results;
			return json_encode($results);
	}
	
		public function wakeupDBConnection(){
		parent::__construct();
		return 0;
	} 
	
		public function breakDBConnection(){
		parent::__destruct();
		return 0;
	} 
	
	public function createTransaction($userid, $recipientid, $amount, $comment)
	{
		$availableFunds = $this->getbalance($userid);
	}
	
	
	
}



?>