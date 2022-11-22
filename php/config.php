<?php
require 'vendor/autoload.php';

use Bcrypt\Bcrypt;
function isLogged(){
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
		return true;
	else
		return false;
}

function emptyInputLogin($id, $password){
	if(empty($id) || empty($password)){
		return true;
	}
	return false;
}

function emptyInputRegister($firstName, $lastName, $email, $password){
	if(empty($firstName) || empty($lastName) || empty($email) || empty($password)){
		return true;
	}
	return false;
}

function idExists($conn, $username){
	$sql = "SELECT * FROM users WHERE userID = ?;";
	$stmt = mysqli_stmt_init($conn);

	//	Check if statement fails
	if(!mysqli_stmt_prepare($stmt, $sql)){
		// header("Location: login?error=2");
		// exit();
		return false;
	}
	
	mysqli_stmt_bind_param($stmt, "s", $username);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	if($row = mysqli_fetch_assoc($result)){
		return $row;
	}
	else{
		return false;
	}

	mysqli_stmt_close($stmt);
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

function isAdmin(){
	
	if (isset($_ENV['USER_TYPE']) && $_ENV['USER_TYPE'] == 1)
		return true;
	else
		return false;
}