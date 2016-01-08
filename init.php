<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('classes/Coca.php');
require_once('classes/Mailer.php');
include_once('functions/functions.php');

// Setting change into database
class InitCoca extends Coca {

	// init.php?service=requestNewChange&params[createBy]=omar.yerden&params[requestBy]=marcelo.blanco&params[requestTitle]=RequestTest&params[requestDescription]=TestTestTest&params[users][]=omaryer&params[users][]=ignacio.mondino&params[servers][]=legabox8&params[servers][]=legabox9
	public function requestNewChange($params) {
		if(!isset($params['createBy'])){ die(returnError(106, 'Missing createBy')); }
		if(!isset($params['users'])){ die(returnError(105, 'Missing executors')); }
		if(!isset($params['servers'])){ die(returnError(105, 'Missing servers')); }

		// Begin transaction
		$this->beginTransaction();

		//Inserting in changes
		$this->change_id = $this->createRequest($params['createBy'], $params['requestBy'], $params['requestTitle'], $params['requestDescription']);

		if(!$this->change_id){ $this->rollbackTransaction(); die(returnError(111, 'An error ocurred, please try again later')); }

		foreach($params['users'] as $user){
			$result = $this->assingUserToRequest($this->change_id, $user, false);
			if(!$result){ $this->rollbackTransaction(); die(returnError(112, 'An error ocurred, please try again later')); }
		}

		foreach($this->getUsersApprovers() as $user){
			$result = $this->assingUserToRequest($this->change_id, $user, true);
			if(!$result){ $this->rollbackTransaction(); die(returnError(113, 'An error ocurred, please try again later')); }
		}

		foreach($params['servers'] as $server){
			$result = $this->assingServerToRequest($this->change_id, $server);
			if(!$result){ $this->rollbackTransaction(); die(returnError(114, 'An error ocurred, please try again later')); }
		}

		$this->commitTransaction();
		echo json_encode( array('status'=>'ok', 'message'=>'Request create successful', 'change_id'=>$this->change_id) );
	}

	// init.php?service=sendEmailToApprovers&params[changeId]=16
	public function sendEmailToApprovers($params) {
		if(!isset($params['changeId'])){ die(returnError(105, 'Missing or invalid change id')); }

		$cocaMailer = new CocaMailer();

		$approvers = $this->getRequestUsers($params['changeId'], true);

		if(count($approvers) <= 0){ die(returnError(119, 'An error ocurred, please try again later')); }

		foreach($approvers as $approver){

			$approversData = $this->getTokenAndEmail($params['changeId'], $approver);
			$changeData = $this->getChange($params['changeId']);
			$data = array_merge($changeData, $approversData);

			$data['execute_by'] = $this->getRequestUsers($params['changeId'], false);
			$data['servers_to'] = $this->getRequestServers($params['changeId']);

			$sendEmail = $cocaMailer->sendMailToApprovers($data);

			if(!$sendEmail){
				die(returnError(118, 'An error ocurred, please try again later'));
			}
		}
		echo json_encode( array('status'=>'ok', 'message'=>'Email is successfully sent to approvers', 'change_id'=>$this->change_id) );
	}

	// init.php?service=sendEmailToExecutors&params[changeId]=16
	public function sendEmailToExecutors($params) {
		if(!isset($params['changeId'])){ die(returnError(105, 'Missing or invalid change id')); }

		$cocaMailer = new CocaMailer();

		$executors = $this->getRequestUsers($params['changeId'], false);

		if(count($executors) <= 0){ die(returnError(119, 'An error ocurred, please try again later')); }

		foreach($executors as $executor){

			$executorData = $this->getTokenAndEmail($params['changeId'], $executor);
			$changeData = $this->getChange($params['changeId']);
			$data = array_merge($changeData, $executorData);

			$data['execute_by'] = $this->getRequestUsers($params['changeId'], false);
			$data['servers_to'] = $this->getRequestServers($params['changeId']);

			$sendEmail = $cocaMailer->sendMailToExecutors($data);

			if(!$sendEmail){
				die(returnError(118, 'An error ocurred, please try again later'));
			}
		}
		echo json_encode( array('status'=>'ok', 'message'=>'Email is successfully sent to executors', 'change_id'=>$this->change_id) );
	}

	// init.php?service=approveChangeRequest&params[acceptToken]=290f05bf1f0d062a91144a165b30991f
	public function approveChangeRequest($params) {
		if(!isset($params['acceptToken'])){ die(returnError(105, 'Missing or invalid accept token')); }
		$approve = $this->approveChange($params['acceptToken']);

		if(!$approve){ die(returnError(118, 'An error ocurred, please try again later')); }
		else{
			if(strpos($approve, 'error') === false){
				echo json_encode( array('status'=>'ok', 'message'=>'The request Change has been approved', 'change_id'=>$this->change_id) );
			}else{
				echo $approve;
			}
		}
	}

	// init.php?service=rejectChangeRequest&params[rejectToken]=3e54ba4f8e2ca7a5f5ba5ab6f74eba93
	public function rejectChangeRequest($params) {
		if(!isset($params['rejectToken'])){ die(returnError(105, 'Missing or invalid accept token')); }
		$reject = $this->rejectChange($params['rejectToken']);

		if(!$reject){ die(returnError(118, 'An error ocurred, please try again later')); }
		else{
			if(strpos($reject, 'error') === false){
				echo json_encode( array('status'=>'ok', 'message'=>'The request Change has been rejected', 'change_id'=>$this->change_id) );
			}else{
				echo $reject;
			}
		}
	}

	// init.php?service=getChangesForMe&params[userId]=omar.yerden
	public function getChangesForMe($params) {
		if(!isset($params['userId'])){ die(returnError(105, 'Missing or invalid user id')); }
		$limit = isset($params['limit']) ? $params['limit'] : 0;
		$orderBy = isset($params['orderBy']) ? $params['orderBy'] : false;
		$data = $this->getChangesByUser($params['userId'], $limit, $orderBy);

		if(!$data){ die(returnError(118, 'An error ocurred, please try again later')); }

		echo json_encode( array('status'=>'ok', 'data'=>$data) );
	}

	// init.php?service=getStats
	public function getStats($params) {
		$data = $this->countChangeByStatus();
		if(!$data){ die(returnError(118, 'An error ocurred, please try again later')); }
		echo json_encode( array('status'=>'ok', 'data'=>$data));
	}

	// init.php?service=commentRequest&params[changeId]=32&params[userId]=omar.yerden&params[approver]=true&params[comment]=
	public function commentRequest($params) {
		if(!isset($params['changeId'])){ die(returnError(105, 'Missing or invalid change id')); }
		if(!isset($params['userId'])){ die(returnError(105, 'Missing or invalid user id')); }
		if(!isset($params['comment'])){ die(returnError(105, 'Missing or invalid comment')); }

		$comment_id = $this->commentChangeRequest($params['changeId'], $params['userId'], $params['comment']);

		echo json_encode( array('status'=>'ok', 'id'=>$comment_id) );
	}
}

$service = isset($_REQUEST['service']) ? $_REQUEST['service'] : false;
$params = isset($_REQUEST['params']) ? $_REQUEST['params'] : false;

if(!$service){ die(returnError(110, 'Missing Serivce')); }

$InitCoca = new InitCoca();

if(!method_exists($InitCoca, $service)){ die(returnError(100, 'The service you looking for is invalid')); }

// Execute the required function
$InitCoca->$service($params);

?>