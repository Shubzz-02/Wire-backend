<?php
 include 'db/db_connect.php';
 include 'functions.php';
// $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
// // Output: 54esmdr0qf
// echo substr(str_shuffle($permitted_chars), 0, 10);
	$response = array();
	function ll(){
	$uq_key = array();
	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
	// for($i = 0; $i <= 5; $i++){
	// 	$uq_key[i] = substr(str_shuffle($permitted_chars), 0, 10);
	// }
	// for($i = 0; $i <= 5; $i++){
	// 	echo $uq_key[i];
	// }

	$uq_key[1] = substr(str_shuffle($permitted_chars), 0, 10);
	$uq_key[2] = substr(str_shuffle($permitted_chars), 0, 10);
	$uq_key[3] = substr(str_shuffle($permitted_chars), 0, 10);
	$uq_key[4] = substr(str_shuffle($permitted_chars), 0, 10);
	return $uq_key;
	}
	$uq_key = array();
	$uq_key = ll();
	$response["status"] = 0;
	$response["message"] = "User created";
	$response["uq1"] = $uq_key[1];
	$response["uq2"] =$uq_key[2];
	$response["uq3"]= $uq_key[3];
	$response["uq4"] =$uq_key[4];

	$user_id = getId("rawatsubhash02@gmail.com");
	echo $user_id;
	//putKeys($user_id,$uq_key);
	echo "done";
	echo "<BR>";
	echo json_encode($response);
	$keys = array();
	echo getKeysFromDatabase($user_id)[1];
	echo getKeysFromDatabase($user_id)[1];
	echo "<br>";
	echo getKeysFromDatabase($user_id)[2];
	echo "<br>";
	echo getKeysFromDatabase($user_id)[3];
	echo "<br>";
	echo getKeysFromDatabase($user_id)[4];
	echo "<br>";
	$uq = getKeysFromDatabase($user_id);
echo $uq[1];
?>

