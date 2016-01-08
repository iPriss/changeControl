<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('functions/functions.php');

class DBaccess {

	private $dbCoca;
	private $query;
	private $result;

	function __construct() {
		// Analizar con secciones
		$config = parse_ini_file("config.ini", true);
		$this -> dbCoca = pg_connect($config['dbCoca']);
	}

	public function beginTransactionOnDB() {
		pg_query('BEGIN');
	}

	public function rollbackTransactionOnDB() {
		pg_query('ROLLBACK');
	}

	public function commitTransactionOnDB() {
		pg_query('COMMIT');
	}

	public function createRequestOnDB($createdBy, $requestBy, $requestTitle, $requestDescription) {
		$date = date('Y-m-d H:i:s');
		$this -> query = "INSERT INTO changes (change_title, change_description, created_by, request_by, change_status, date_created, date_lastupdate)
						  VALUES ('{$requestTitle}',
						  		  '{$requestDescription}',
						  		  '{$createdBy}',
						  		  '{$requestBy}',
						  		  'pending',
						  		  '{$date}', '{$date}') RETURNING change_id";
		$this -> result = pg_query($this->dbCoca, $this -> query);
		$changeId = pg_fetch_row($this -> result);
		return $changeId[0];
	}

	public function getChangeFromDB($changeId) {
		$this -> query = "SELECT * FROM changes WHERE change_id = '{$changeId}'";
		$this -> result = pg_query($this->dbCoca, $this -> query);
		return pg_fetch_array($this -> result, NULL, PGSQL_ASSOC);
	}

	public function getChangeByUserFromDB($userId, $limit, $orderBy) {
		$this -> query = "SELECT * FROM changes WHERE change_id IN (SELECT change_id FROM changes_users WHERE user_id = '{$userId}') {$orderBy} LIMIT {$limit}";
		$this -> result = pg_query($this->dbCoca, $this -> query);
		return pg_fetch_all($this -> result);
	}

	public function assingUserToRequestOnDB($changeId, $userId, $acceptToken, $rejectToken, $isApprover) {
		//[Pending] validate constrain
		$dateCreated = date('Y-m-d H:i:s');
		$this -> query = "INSERT INTO changes_users (change_id, user_id, accept_token, reject_token, is_approver)
						  VALUES ('{$changeId}','{$userId}','{$acceptToken}','{$rejectToken}','{$isApprover}')";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		return pg_affected_rows($this -> result);
	}

	public function getRequestUsersFromDB($changeId, $approver) {
		if(!$approver){ $approver = 'f'; }else{ $approver = 't'; }
		$this -> query = "SELECT user_id FROM changes_users WHERE change_id = '{$changeId}' AND is_approver = '{$approver}'";
		$this -> result = pg_query($this->dbCoca, $this -> query);
		// return pg_fetch_all($this -> result);
		$data = array();
		while($row = pg_fetch_row($this->result)){ $data[] = $row[0]; }
		return $data;
	}

	public function getTokenAndEmailFromDB($changeId, $userId) {
		$this -> query = "SELECT tokens.accept_token, tokens.reject_token, users.user_email
						  FROM changes_users AS tokens, users
						  WHERE tokens.user_id = '{$userId}' AND tokens.change_id = '{$changeId}' AND users.user_id = '{$userId}'";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		return pg_fetch_array($this -> result, NULL, PGSQL_ASSOC);
	}

	public function assingServerToRequestOnDB($changeId, $serverTo, $status) {
		$this -> query = "INSERT INTO changes_servers (change_id, server, status)
						  VALUES ('{$changeId}','{$serverTo}','{$status}')";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		return pg_affected_rows($this -> result);
	}

	public function getRequestServersFromDB($changeId) {
		$this -> query = "SELECT server FROM changes_servers WHERE change_id = '{$changeId}'";
		$this -> result = pg_query($this->dbCoca, $this -> query);
		// return pg_fetch_all($this -> result);
		$data = array();
		while($row = pg_fetch_row($this->result)){$data[] = $row[0]; }
		return $data;
	}

	public function statusChangeOnDB($changeId, $changeStatus) {
		$currentDate = date('Y-m-d H:i:s');
		$this -> query = "UPDATE changes SET change_status = '{$changeStatus}', date_lastupdate = '{$currentDate}' WHERE change_id = '{$changeId}'";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		return pg_affected_rows($this -> result);
	}

	public function getChangeByTokenFromDB($token) {
		$this -> query = "SELECT change_id FROM changes_users WHERE (accept_token = '{$token}' OR reject_token = '{$token}')";
		$this -> result = pg_query($this->dbCoca, $this -> query);
		if(pg_num_rows($this -> result) > 0){ return pg_fetch_result($this -> result, 0, 0); }else{return false; }
	}

	public function getTokenDataFromDB($token){
		$this -> query = "SELECT * FROM changes_users WHERE (accept_token = '{$token}' OR reject_token = '{$token}')";
		$this -> result = pg_query($this->query);
		return pg_fetch_array($this -> result, NULL, PGSQL_ASSOC);
	}

	public function useToken($tokenUsed, $token) {
		$currentDate = date('Y-m-d H:i:s');
		$this -> query = "UPDATE changes_users SET token_used = '{$tokenUsed}', date_lastupdate = '{$currentDate}' WHERE (accept_token = '{$token}' OR reject_token = '{$token}')";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		return pg_affected_rows($this -> result);
	}

	public function getUsersApproversFromDB() {
		$this -> query = "SELECT user_id FROM users WHERE is_approver = 't'";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		$data = array();
		while($row = pg_fetch_row($this->result)){$data[] = $row[0]; }
		return $data;
	}

	public function getUserDataFromDB($userId) {
		$this -> query = "SELECT * FROM users WHERE user_id = '{$userId}'";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		return pg_fetch_array($this -> result, NULL, PGSQL_ASSOC);
	}

	public function createUserObDB($userId, $userName, $userEmail, $userStatus, $userSecret, $isApprover){
		//[Pending] update USER
		$dateCreated = date('Y-m-d H:i:s');
		$this -> query = "INSERT INTO users (user_id, user_name, user_email, user_status, date_created, user_secret, is_approver)
						  VALUES ('{$userId}','{$userName}', '{$userEmail}', '{$userStatus}', '{$dateCreated}','{$userSecret}','{$isApprover}')";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		return pg_affected_rows($this -> result);
	}

	public function countChangeByStatusFromDB($status) {
		$this -> query = "SELECT count(*) AS total FROM changes WHERE change_status = '{$status}'";
		$this -> result = pg_query($this -> dbCoca, $this -> query);

		return pg_fetch_result($this -> result, 0, 0);
	}

	public function commentChangeRequestOnDB($changeId, $userId, $approver, $comment) {
		$date = date('Y-m-d H:i:s');
		$this -> query = "INSERT INTO changes_comments (change_id, user_id, is_approver, comment)
						  VALUES ('{$changeId}','{$userId}','{$approver}','{$comment}') RETURNING comment_id";
		$this -> result = pg_query($this -> dbCoca, $this -> query);
		$commentId = pg_fetch_row($this -> result);
		return $commentId[0];
	}

	function __destruct(){
		pg_close($this -> dbCoca);
	}

}

?>