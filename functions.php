<?php
$random_salt_length = 32;
/**
* Queries the database and checks whether the user already exists
* 
* @param $username
* 
* @return
*/
function userExists($username){
	$query = "SELECT username FROM member WHERE username = ?";
	global $con;
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		if($stmt->num_rows == 1){
			$stmt->close();
			return true;
		}
		$stmt->close();
	}
 
	return false;
}
 
/**
* Creates a unique Salt for hashing the password
* 
* @return
*/
function getSalt(){
	global $random_salt_length;
	return bin2hex(openssl_random_pseudo_bytes($random_salt_length));
}
 
/**
* Creates password hash using the Salt and the password
* 
* @param $password
* @param $salt
* 
* @return
*/
function concatPasswordWithSalt($password,$salt){
	global $random_salt_length;
	if($random_salt_length % 2 == 0){
		$mid = $random_salt_length / 2;
	}
	else{
		$mid = ($random_salt_length - 1) / 2;
	}
 
	return
	substr($salt,0,$mid - 1).$password.substr($salt,$mid,$random_salt_length - 1);
 
}
function getId($username){
	$query = "SELECT user_id FROM member WHERE username = ?";
	global $con;
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->bind_result($user_id);
		if($stmt->fetch()){
			$stmt->close();
			return $user_id;
		}
	}
}
function getkeys(){
	$uq_key = array();
	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
	$uq_key[1] = substr(str_shuffle($permitted_chars), 0, 10);
	$uq_key[2] = substr(str_shuffle($permitted_chars), 0, 10);
	$uq_key[3] = substr(str_shuffle($permitted_chars), 0, 10);
	$uq_key[4] = substr(str_shuffle($permitted_chars), 0, 10);
	return $uq_key;
}

function putKeys($user_id,$uq_key){
	$insertQuery  = "INSERT INTO tracking(user_id,uq_key) VALUES(?,?)";
	global $con;
	if($stmt = $con->prepare($insertQuery)){
		$stmt->bind_param("ss",$user_id,$uq_key[1]);
		$stmt->execute();
		$stmt->bind_param("ss",$user_id,$uq_key[2]);
		$stmt->execute();
		$stmt->bind_param("ss",$user_id,$uq_key[3]);
		$stmt->execute();
		$stmt->bind_param("ss",$user_id,$uq_key[4]);
		$stmt->execute();
		$stmt->close();
	}
}


function getKeysFromDatabase($user_id){
	global $con;
	$query = "SELECT uq_key FROM tracking WHERE user_id = ".$user_id;
	$result = mysqli_query($con , $query);
	$key = array();
	$k = mysqli_fetch_row($result);
	$key[1] = $k[0];
	$k = mysqli_fetch_row($result);
        $key[2] = $k[0];
	$k = mysqli_fetch_row($result);
        $key[3] = $k[0];
	$k = mysqli_fetch_row($result);
        $key[4] = $k[0];
	//echo "<br>".$key[1]."<br>"."<br>".$key[2]."<br>"."<br>".$key[3]."<br>";
	return $key;
}
?>

