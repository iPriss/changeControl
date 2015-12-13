<?php

	function returnError($errorCode, $errorMessage, $json=true) {
		$error = array('status'=>'error', 'errorCode'=>$errorCode, 'errorMessage'=>$errorMessage);
		if($json === true) { return json_encode($error); }
		else{ return $error; }
	}

	function generateRandomString($length = 12) {
	    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	function validateParam($param, $dieOnError, $errorMessage) {
		if(!isset($param) || empty($param)) {
			if( $dieOnError === True ) {
				die(json_encode($errorMessage));
			}else{
				return Null;
			}
		}else{
			return $param;
		}
	}

?>