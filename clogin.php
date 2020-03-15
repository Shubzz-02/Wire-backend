<?php
$response = array();
include 'db/db_connect.php';
include 'functions.php';

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,TRUE);	

if(isset($input['username']) && isset($input['password']) && isset($input['key'])){
	$username = $input['username'];
	$password = $input['password'];
	$key	  = $input['key'];
	$query	  = "SELECT member.full_name, member.password_hash, member.salt, tracking.uq_key, tracking.taken FROM member, tracking WHERE member.username = ? and tracking.uq_key = ? and tracking.user_id = member.user_id";

	if($stmt = $con->prepare($query)){
		$stmt->bind_param("ss",$username,$key);
		$stmt->execute();
		$stmt->bind_result($fullName,$passwordHashDB,$salt,$uq_key,$taken);
		if($stmt->fetch()){
			if(password_verify(concatPasswordWithSalt($password,$salt),$passwordHashDB)){
				if($taken != 0){
					$response["status"] = 1;
                	$response["message"] = "Key Already used";
				}else{
					$response["status"] = 0;
                	$response["message"] = "Login successful";
                	$response["full_name"] = $fullName;
				}
			}else{
				$response["status"] = 1;
                $response["message"] = "Invalid username and password combination";
			}
		}else{
			$response["status"] = 1;
            $response["message"] = "Invalid username and password combination or Invalid Key";
		}
		$stmt->close();
	}
}else{
	$response["status"] = 2;
    $response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>
