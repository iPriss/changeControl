<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('functions/functions.php');
include_once('add-ons/PHPMailer/class.phpmailer.php'); // Include PHPMailer
include_once('add-ons/PHPMailer/class.smtp.php'); // Include PHPMailer

class CocaMailer extends PHPMailer {

	protected $host;
	protected $port;
	protected $username;
	protected $password;

	public $createdBy; // String
	public $requestBy; // String
	public $executeBy; // Array data
	public $serversTo; // Array data
	public $requestTitle; // String
	public $requestDescription; // String


	function __construct(){
		// $this->SMTPDebug = 3;
		$this->Host = 'mail.leandergames.com';
		$this->SMTPAuth = true;
		$this->Username = 'changes.control@leandergames.com';
		$this->Password = 'AhSDtjmc';
		$this->STMPSecure = 'tls';
		$this->Port = 587;

		$this->setFrom('changes.control@leandergames.com', 'Leander - CoCa');
		$this->addReplyTo('noreplay@leandergames.com', 'No Reply');

		$this->AddEmbeddedImage('templates/emails/leander.png', 'leander-logo', 'leander.png', 'base64', 'image/png');

		$this->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
		$this->isSMTP();
		$this->isHTML(true);
	}

	public function sendMailToApprovers($params) {
		// $email, $acceptToken, $rejectToken,
		// Creating body
		$this->addAddress($params['user_email']);
		$this->Subject = '[ChangeRequest #' . $params['change_id'] . '] ' . $params['change_title'];

		ob_start();
		require('templates/emails/approval_request.php');
		$this->Body = ob_get_clean();

		return PHPMailer::send();
	}

	public function sendMailToExecutors($params) {
		// $email, $acceptToken, $rejectToken,
		// Creating body
		$this->addAddress($params['user_email']);
		$this->Subject = '[ChangeRequest #' . $params['change_id'] . '] ' . $params['change_title'];

		ob_start();
		require('templates/emails/executors_info.php');
		$this->Body = ob_get_clean();

		return PHPMailer::send();
	}

	public function sendMailStatusToExecutors($params) {
		// $email, $acceptToken, $rejectToken,
		// Creating body
		$this->addAddress($params['user_email']);
		$this->Subject = '[ChangeRequest #' . $params['change_id'] . '] ' . $params['change_status'];

		if($params['change_status'] == 'Approved'){
			$this->Body = 'The change request ' . $params['change_id'] . ' has been approved by ' . $params['approver'];
		}else{
			$this->Body = 'The change request ' . $params['change_id'] . ' has been rejected by ' . $params['approver'];
		}

		return PHPMailer::send();
	}
}

?>