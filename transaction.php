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
	
	public function getTransactiondetails($transactionId) {
		parent::__construct();
		$detailsquery = $this->pdo->prepare("SELECT sender, receiver, amount, comment, timestamp FROM `transactionoverwiew` WHERE transactionId = ?");
        $detailsquery->bindParam(1, $transactionId, PDO::PARAM_INT);
        $detailsquery->execute();
        $result = $detailsquery->fetch(PDO::FETCH_ASSOC);
		return json_encode($result);
	}
	

	
	public function getTransactionOverview($userid,$isajax=null){
		parent::__construct();
		$qry = "SELECT transactionId, sender, receiver ,senderid, receiverid, amount, comment, transactionoverwiew.timestamp as timestamp FROM `transactionoverwiew` WHERE senderid=? OR receiverid=? ";
		if(!is_null($isajax))
	    {
			$qry = $qry."AND transactionoverwiew.timestamp > DATE_ADD(NOW(), INTERVAL -10 SECOND)";
		}
		$GetTranOverwiew = $this->pdo->prepare($qry);
		$GetTranOverwiew->bindParam(1, $userid);
		$GetTranOverwiew->bindParam(2, $userid);
        $GetTranOverwiew->execute();
        $result = $GetTranOverwiew->fetchAll(PDO::FETCH_ASSOC);
		$results = array();
		foreach($result as $row){
			if ($userid == $row['receiverid']){
				if($row['amount']>1){
					$pluralflag = "tokens";
					
				}
				else{
					$pluralflag = "token";
				}
				$dt = strtotime($row['timestamp']);
				
				$listitem = $row['sender']." sent you ".$row['amount']." $pluralflag on ". date("l jS \of F Y H:i:s",$dt);
				//error_log($listitem,0);
				$tuple = array();
				$tuple['transactioninfo'] = $listitem;
				$tuple['transactionId'] = $row['transactionId'];
				array_push($results,json_encode($tuple));
			}
			elseif($userid == $row['senderid']){
				if($row['amount']>1){
					$pluralflag = "tokens";
					
				}
				else{
					$pluralflag = "token";
				}
				$dt = strtotime($row['timestamp']);
				$listitem ="you sent ".$row['amount']." $pluralflag to ".$row['receiver']." on ". date("l jS \of F Y H:i:s",$dt);
				
				$tuple = array();
				$tuple['transactioninfo'] = $listitem;
				$tuple['transactionId'] = $row['transactionId'];
				array_push($results,json_encode($tuple));

			}
		}
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
	{	parent::__construct();
		$makeTransferQuery = $this->pdo->prepare('INSERT INTO mysite.transactions (sender,receiver,amount,comment) VALUES (?,?,?,?)');
        $makeTransferQuery->bindParam(1, $userid);
        $makeTransferQuery->bindParam(2, $recipientid);
        $makeTransferQuery->bindParam(3, $amount);
        $makeTransferQuery->bindParam(4, $comment);
        $result = $makeTransferQuery->execute();
		return $result;
		
	}
	
	
	
}



?>