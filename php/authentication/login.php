<?php
require 'vendor/autoload.php';
use Bcrypt\Bcrypt;

function emptyInput($id, $password){
	if(empty($id) || empty($password)){
		return true;
	}
	return false;
}

function loginUser($conn, $id, $password){
	$idExists = idExists($conn, $id);

	//	User does not exist
	if($idExists === false){
		// header("Location: login?error=3");
		// exit();
		return false;
	}

	$passwordHashed = $idExists['password'];

	$bcrypt = new Bcrypt();

	if($bcrypt->verify($password, $passwordHashed)){
		$checkedPassword = true;
	}
	else{
		$checkedPassword = false;
	}

	//	Password does not match
	if($checkedPassword === false){
		// header("Location: login?error=4");
		// exit();
		return false;
	}
	//	SUCCESS
	else if($checkedPassword === true){
		return $idExists;
	}
}

function getRoleIDs($conn, $userID){
	$sql = 'SELECT role_id FROM userroles WHERE user_id = ?;';

	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)){
		return 4;
	}
	else{
		mysqli_stmt_bind_param($stmt, "s", $userID);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);

		while($row = mysqli_fetch_assoc($res)){
			$roleIDs[] = $row;
		}

		mysqli_stmt_close($stmt);
	}

	return $roleIDs;
}

function getRoles($conn, $userID){
	$roleIDs = getRoleIDs($conn, $userID);

	foreach($roleIDs as $roleID){

		$sql = 'SELECT * FROM roles WHERE id = ?;';

		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt, $sql)){
			return 4;
		}
		else{
			mysqli_stmt_bind_param($stmt, "s", $roleID['role_id']);
			mysqli_stmt_execute($stmt);
			$res = mysqli_stmt_get_result($stmt);
			// if(!$row = mysqli_fetch_assoc($res)){
			// 	return false;
			// }

			if($row = mysqli_fetch_assoc($res)){
				$roles[] = $row;
			}

			mysqli_stmt_close($stmt);

			
		}
	}

	return $roles;
}