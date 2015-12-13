<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('DBAccess.php');
include_once('functions/functions.php');

class Coca extends DBAccess {
	// Defining private
	private $userId;

	protected $config;

	// Required params to create a request
	public $createdBy; // String
	public $requestBy; // String
	public $executeBy; // Array data
	public $serversTo; // Array data
	public $requestTitle; // String
	public $requestDescription; // String

	// Data returned from insert into dataBase
	public $change_id;
	public $user_id;

	public $acceptToken;
	public $rejectToken;


	function __construct() {
		$this->config = parse_ini_file("config.ini", true);
		DBAccess::__construct();
	}

	public function createUser($userName, $userEmail, $isApprover) {
		$userSecret = generateRandomString();

		$isApprover = ($isApprover) ? 't' : 'f';

		$userId = strtolower(str_replace(' ', '.', $userName));
		$userName = validateParam($userName, True, 'Invalid or Missing user name');
		$userEmail = validateParam($userEmail, True, 'Invalid or Missing user email');
		$userStatus = 'active';

		$userId = $this -> createUserObDB($userId, $userName, $userEmail, $userStatus, $userSecret, $isApprover);
		return $userId;
	}

	public function getUsersApprovers() {
		return $this->getUsersApproversFromDB();
	}

	public function getUserData($userId) {
		return $this->getUserDataFromDB($userId);
	}

	public function createRequest($createdBy, $requestBy, $requestTitle, $requestDescription) {
		$this -> createdBy = validateParam($createdBy, True, 'Invalid or Missing create by');
		$this -> requestBy = validateParam($requestBy, True, 'Invalid or Missing request by');
		$this -> requestTitle = validateParam($requestTitle, True, 'Invalid or Missing request title');
		$this -> requestDescription = validateParam($requestDescription, True, 'Invalid or Missing request description');

		// Insert data on DB
		$this -> change_id = $this -> createRequestOnDB($this->createdBy, $this->requestBy, $this->requestTitle, $this->requestDescription);

		if(empty($this -> change_id)) { return returnError(20, 'Error trying to create a new request on data bases, pleas try again later'); }
		return $this -> change_id;
	}

	public function getChange($changeId) {
		$this -> change_id = isset($changeId) ? $changeId : $this -> change_id;
		return $this->getChangeFromDB($this->change_id);
	}

	public function getChangesByUser($userId) {
		$this -> user_id = isset($userId) ? $userId : $this -> user_id;
		return $this->getChangeByUserFromDB($this->user_id);
	}

	public function assingUserToRequest($changeId, $userId, $isApprover) {
		$isApprover = ($isApprover) ? $isApprover : 'f';
		$this -> change_id = isset($changeId) ? $changeId : $this -> change_id;

		$user_data = $this->getUserDataFromDB($userId);

		if(!$user_data){ return returnError(50, 'Invalid user'); }

		$this -> acceptToken = md5($user_data['user_email'].$user_data['user_secret'].$this->change_id.$this->config['salt'].'accept');
		$this -> rejectToken = md5($user_data['user_email'].$user_data['user_secret'].$this->change_id.$this->config['salt'].'reject');

		return $this->assingUserToRequestOnDB($this->change_id, $userId, $this->acceptToken, $this->rejectToken, $isApprover);
	}

	public function getRequestUsers($changeId, $approver) {
		$this -> change_id = validateParam($changeId, True, 'Invalid or Missing change id');
		$approver = isset($approver) ? $approver : False;
		return $this->getRequestUsersFromDB($this->change_id, $approver);
	}

	public function assingServerToRequest($changeId, $serversTo) {
		$this -> serversTo = validateParam($serversTo, True, 'Invalid or Missing servers to');
		$this -> change_id = isset($changeId) ? $changeId : $this -> change_id;
		return $this -> assingServerToRequestOnDB($this->change_id, $serversTo, 'pending');
	}

	public function getRequestServers($changeId) {
		$this -> change_id = validateParam($changeId, True, 'Invalid or Missing change id');
		return $this->getRequestServersFromDB($this->change_id);
	}

	public function approveChange($acceptToken) {
		$this -> acceptToken = validateParam($acceptToken, True, 'Invalid or Missing token');

		$token_valid = $this->validateToken($acceptToken);

		if(strpos($token_valid, 'error') !== false){ return $token_valid; }

		$this -> change_id = $this->getChangeByTokenFromDB($this->acceptToken);
		$change_data = $this->getChangeFromDB($this -> change_id);

		if($change_data['change_status'] == 'reject'){ return returnError(73, 'This change request already has been rejected'); }
		if($change_data['change_status'] == 'accepted'){ return returnError(73, 'This change request already has been accepted'); }

		$token_used = $this->useToken('accept', $this->acceptToken);

		if(!$token_used){ return returnError(43, 'Error trying to change the status of the Request'); }

		return $this->statusChangeOnDB($this->change_id, 'approved');
	}

	public function rejectChange($rejectToken) {
		$this -> rejectToken = validateParam($rejectToken, True, 'Invalid or Missing token');

		$token_valid = $this->validateToken($rejectToken);

		if(strpos($token_valid, 'error') !== false){ return $token_valid; }

		$this -> change_id = $this->getChangeByTokenFromDB($this->rejectToken);
		$change_data = $this->getChangeFromDB($this -> change_id);

		if($change_data['change_status'] == 'reject'){ return returnError(73, 'This change request already has been rejected'); }

		$token_used = $this->useToken('reject', $this->rejectToken);

		if(!$token_used){ return returnError(43, 'Error trying to change the status of the Request'); }

		return $this->statusChangeOnDB($this->change_id, 'rejected');
	}

	public function getTokenAndEmail($changeId, $userId) {
		$this -> user_id = validateParam($userId, True, 'Invalid or Missing change id');
		$this -> change_id = validateParam($changeId, True, 'Invalid or Missing change id');

		return $this->getTokenAndEmailFromDB($this->change_id, $this->user_id);
	}

	public function getChangeByToken($token) {
		$token = validateParam($token, True, 'Invalid or Missing token');
		return $this->getChangeByTokenFromDB($token);
	}

	public function validateToken($token){
		$token_data = $this->getTokenDataFromDB($token);

		if(!$token_data){ return returnError(53, 'Invalid or missing token'); }

		if($token_data['accept_token'] == $token){ $tokenType = 'accept'; }
		else{ $tokenType = 'reject'; }

		if($token_data['token_used'] == $tokenType){ return returnError(54, 'Token already used'); }

		return true;
	}

	public function beginTransaction() {
		$this->beginTransactionOnDB();
	}

	public function rollbackTransaction() {
		$this->rollbackTransactionOnDB();
	}

	public function commitTransaction() {
		$this->commitTransactionOnDB();
	}

}

?>
