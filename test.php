<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('classes/Coca.php');
require_once('classes/Mailer.php');
include_once('functions/functions.php');

	echo "Cocaaaa!! <br>";

	$coca = new Coca();
	$cocaMailer = new CocaMailer();

	// $coca->createRequest('omar.yerden', 'marcelo.blanco', 'Request Test', 'Test Description for this request');
	// var_dump($coca->createUser('Omar Yerden', 'omar@leandergames.com', true)); echo "<br>";
	// print_r($coca->getUserData('omar.yerden'));

	// $coca->assingUserToRequest(10, 'omar.yerden', True);
	// var_dump($coca->assingUserToRequest(10, 'ignacio.mondino', False)); echo "<br>";
	// $coca->assingServerToRequest(10, 'legabox11');

	// echo $coca->approveChange("a268a5dae3f04181e49f2d7a8135ad71");
	// echo $coca->rejectChange("f268ce596e11cc26c0ff52dcf50002d7");

	// var_dump($coca->getChangeIdByToken('290f05bf1f0d062a91144a165b30991f')); echo "<br>";

	$allApprovers = $coca->getUsersApprovers();

	$approvers = $coca->getRequestUsers(16, true);
	$executors = $coca->getRequestUsers(16, false);
	$servers = $coca->getRequestServers(16);

	$data = $coca->getTokenAndEmail(16, 'omar.yerden');
	$params = $coca->getChange(16);

	$params['execute_by'] = array();
	$params['servers_to'] = array();

	// foreach($executors as $key => $val) {
	// 	$params['execute_by'][] = $val['user_id'];
	// }

	// foreach($servers as $key => $val) {
	// 	$params['servers_to'][] = $val['server'];
	// }

	print_r($allApprovers); echo "<br>";
	print_r($approvers); echo "<br>";
	print_r($executors); echo "<br>";
	print_r($servers); echo "<br>";
	print_r($data); echo "<br>";
	print_r($params); echo "<br>";

	// Sen emails
	// $sendEmail = $cocaMailer->sendMailToApprovers($data['user_email'], $data['accept_token'], $data['reject_token'], $params);
	// var_dump($sendEmail);

?>